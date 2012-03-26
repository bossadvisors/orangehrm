<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
    $steps = array('database info', 'version info', 'database changes', 'configuration info');
    $currScreen = $sf_user->getAttribute('currentScreen');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <?php use_stylesheet('style.css') ?>
    <title>OrangeHRM Web Upgrade Wizard</title>
  </head>
  <body>
      <div id="body">
        <div id="logoContainer">
            <?php echo image_tag('orange3.png');?>
        </div>
        <div id="outerBox">
            <table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <?php
                    $tocome = '';
                    for ($i=0; $i < count($steps); $i++) {
                        if ($currScreen == $i) {
                            $tabState = 'Active';
                        } else {
                            $tabState = 'Inactive';
                        }
                ?>
                <td nowrap="nowrap" class="left_<?php echo $tabState?>">&nbsp;</td>
                <td nowrap="nowrap" class="middle_<?php echo $tabState.$tocome?>"><?php echo $steps[$i]?></td>
                <td nowrap="nowrap" class="right_<?php echo $tabState?>">&nbsp;</td>
                <?php
                    if ($tabState == 'Active') {
                        $tocome = '_tocome';
                    }
                }
                ?>
              </tr>
            </table>
            <div name="content" id="content">
                <?php echo $sf_content ?>
            </div>
        </div>
        
        <div id="footer"><a href="http://www.orangehrm.com" target="_blank" tabindex="37">OrangeHRM</a> Web Upgrade Wizard ver 0.2 &copy; OrangeHRM Inc 2005 - 2012 All rights reserved. </div>
    </div>
</body>
</html>

