<?php
/*
 *  $Id: GeneratedObjectTest.php 928 2008-01-18 12:21:27Z hans $
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://propel.phpdb.org>.
 */

require_once 'bookstore/BookstoreTestBase.php';

/**
 * Tests the generated Object classes and LOB behavior.
 *
 * This test uses generated Bookstore classes to test the behavior of various
 * object operations.  The _idea_ here is to test every possible generated method
 * from Object.tpl; if necessary, bookstore will be expanded to accommodate this.
 *
 * The database is relaoded before every test and flushed after every test.  This
 * means that you can always rely on the contents of the databases being the same
 * for each test method in this class.  See the BookstoreDataPopulator::populate()
 * method for the exact contents of the database.
 *
 * @see        BookstoreDataPopulator
 * @author     Hans Lellelid <hans@xmpl.org>
 */
class GeneratedObjectLobTest extends BookstoreTestBase {

	/**
	 * Array of filenames pointing to blob/clob files indexed by the basename.
	 *
	 * @var        array string[]
	 */
	protected $sampleLobFiles = array();

	protected function setUp()
	{
		parent::setUp();
		$this->sampleLobFiles['tin_drum.gif'] = TESTS_BASE_DIR . '/etc/lob/tin_drum.gif';
		$this->sampleLobFiles['tin_drum.txt'] = TESTS_BASE_DIR . '/etc/lob/tin_drum.txt';
		$this->sampleLobFiles['propel.gif'] = TESTS_BASE_DIR . '/etc/lob/propel.gif';
	}

	/**
	 * Gets a LOB filename.
	 *
	 * @param      string $basename Basename of LOB filename to return (if left blank, will choose random file).
	 * @return     string
	 * @throws     Exception - if specified basename doesn't correspond to a registered LOB filename
	 */
	protected function getLobFile($basename = null)
	{
		if ($basename === null) {
			$basename = array_rand($this->sampleLobFiles);
		}

		if (isset($this->sampleLobFiles[$basename])) {
			return $this->sampleLobFiles[$basename];
		} else {
			throw new Exception("Invalid base LOB filename: $basename");
		}
	}

	/**
	 * Test the LOB results returned in a resultset.
	 */
	public function testLobResults()
	{

		$blob_path = $this->getLobFile('tin_drum.gif');
		$clob_path = $this->getLobFile('tin_drum.txt');

		$book = BookPeer::doSelectOne(new Criteria());

		$m1 = new Media();
		$m1->setBook($book);
		$m1->setCoverImage(file_get_contents($blob_path));
		$m1->setExcerpt(file_get_contents($clob_path));
		$m1->save();
		$m1_id = $m1->getId();

		$m1->reload();

		$img = $m1->getCoverImage();
		$txt = $m1->getExcerpt();

		$this->assertType('resource', $img, "Expected results of BLOB method to be a resource.");
		$this->assertType('string', $txt, "Expected results of CLOB method to be a string.");

		$stat = fstat($img);
		$size = $stat['size'];

		$this->assertEquals(filesize($blob_path), $size, "Expected filesize to match stat(blobrsc)");
		$this->assertEquals(filesize($clob_path), strlen($txt), "Expected filesize to match clob strlen");
	}

	/**
	 * Test to make sure that file pointer is not when it is fetched
	 * from the object.
	 *
	 * This is actually a test for correct behavior and does not completely fix
	 * the associated ticket (which was resolved wontfix).
	 *
	 * This does test the rewind-after-save functionality, however.
	 *
	 * @link       http://propel.phpdb.org/trac/ticket/531
	 */
	public function testLobRepeatRead()
	{
		$blob_path = $this->getLobFile('tin_drum.gif');
		$clob_path = $this->getLobFile('tin_drum.txt');

		$book = BookPeer::doSelectOne(new Criteria());

		$m1 = new Media();
		$m1->setBook($book);
		$m1->setCoverImage(file_get_contents($blob_path));
		$m1->setExcerpt(file_get_contents($clob_path));
		$m1->save();

		$img = $m1->getCoverImage();

		// 1) Assert that this resource has been rewound.

		$this->assertEquals(0, ftell($img), "Expected position of cursor in file pointer to be 0");

		// 1) Assert that we've got a valid stream to start with

		$this->assertType('resource', $img, "Expected results of BLOB method to be a resource.");

		// read first 100 bytes
		$firstBytes = fread($img, 100);

		$img2 = $m1->getCoverImage();
		$this->assertSame($img, $img2, "Assert that the two resources are the same.");

		// read next 100 bytes
		$nextBytes = fread($img, 100);

		$this->assertNotEquals(bin2hex($firstBytes), bin2hex($nextBytes), "Expected the first 100 and next 100 bytes to not be identical.");
	}

	/**
	 * Tests the setting of LOB (BLOB and CLOB) values.
	 */
	public function testLobSetting()
	{
		$blob_path = $this->getLobFile('tin_drum.gif');
		$blob2_path = $this->getLobFile('propel.gif');

		$clob_path = $this->getLobFile('tin_drum.txt');
		$book = BookPeer::doSelectOne(new Criteria());

		$m1 = new Media();
		$m1->setBook($book);
		$m1->setCoverImage(file_get_contents($blob_path));
		$m1->setExcerpt(file_get_contents($clob_path));
		$m1->save();
		$m1_id = $m1->getId();

		// 1) Assert that we've got a valid stream to start with
		$img = $m1->getCoverImage();
		$this->assertType('resource', $img, "Expected results of BLOB method to be a resource.");

		// 2) Test setting a BLOB column with file contents
		$m1->setCoverImage(file_get_contents($blob2_path));
		$this->assertType('resource', $m1->getCoverImage(), "Expected to get a resource back after setting BLOB with file contents.");

		// commit those changes & reload
		$m1->save();

		// 3) Verify that we've got a valid resource after reload
		$m1->reload();
		$this->assertType('resource', $m1->getCoverImage(), "Expected to get a resource back after setting reloading object.");

		// 4) Test isModified() behavior
		$fp = fopen("php://temp", "r+");
		fwrite($fp, file_get_contents($blob2_path));

		$m1->setCoverImage($fp);
		$this->assertTrue($m1->isModified(), "Expected Media object to be modified, despite fact that stream is to same data");

		// 5) Test external modification of the stream (and re-setting it into the object)
		$stream = $m1->getCoverImage();
		fwrite($stream, file_get_contents($blob_path)); // change the contents of the stream

		$m1->setCoverImage($stream);

		$this->assertTrue($m1->isModified(), "Expected Media object to be modified when stream contents changed.");
		$this->assertNotEquals(file_get_contents($blob2_path), stream_get_contents($m1->getCoverImage()));

		$m1->save();

		// 6) Assert that when we call the setter with a stream, that the file in db gets updated.

		$m1->reload(); // start with a fresh copy from db

		// Ensure that object is set up correctly
		$this->assertNotEquals(file_get_contents($blob_path), stream_get_contents($m1->getCoverImage()), "The object is not correctly set up to verify the stream-setting test.");

		$fp = fopen($blob_path, "r");
		$m1->setCoverImage($fp);
		$m1->save();
		$m1->reload(); // refresh from db

		// Assert that we've updated the db
		$this->assertEquals(file_get_contents($blob_path), stream_get_contents($m1->getCoverImage()), "Expected the updated BLOB value after setting with a stream.");

		// 7) Assert that 'w' mode works

	}

	public function testLobSetting_WriteMode()
	{
		$blob_path = $this->getLobFile('tin_drum.gif');
		$blob2_path = $this->getLobFile('propel.gif');

		$clob_path = $this->getLobFile('tin_drum.txt');
		$book = BookPeer::doSelectOne(new Criteria());

		$m1 = new Media();
		$m1->setBook($book);
		$m1->setCoverImage(file_get_contents($blob_path));
		$m1->setExcerpt(file_get_contents($clob_path));
		$m1->save();

		MediaPeer::clearInstancePool();

		// make sure we have the latest from the db:
		$m2 = MediaPeer::retrieveByPK($m1->getId());

		// now attempt to assign a temporary stream, opened in 'w' mode, to the db

		$stream = fopen("php://memory", 'w');
		fwrite($stream, file_get_contents($blob2_path));
		$m2->setCoverImage($stream);
		$m2->save();
		fclose($stream);

		$m2->reload();
		$this->assertEquals(file_get_contents($blob2_path), stream_get_contents($m2->getCoverImage()), "Expected contents to match when setting stream w/ 'w' mode");

		$stream2 = fopen("php://memory", 'w+');
		fwrite($stream2, file_get_contents($blob_path));
		rewind($stream2);
		$this->assertEquals(file_get_contents($blob_path), stream_get_contents($stream2), "Expecting setup to be correct");

		$m2->setCoverImage($stream2);
		$m2->save();
		$m2->reload();

		$this->assertEquals(file_get_contents($blob_path), stream_get_contents($m2->getCoverImage()), "Expected contents to match when setting stream w/ 'w+' mode");

	}

}
