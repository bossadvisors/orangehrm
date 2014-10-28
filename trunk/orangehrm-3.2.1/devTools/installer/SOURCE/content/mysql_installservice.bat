@echo off 

if "%OS%" == "Windows_NT" goto WinNT 

:Win9X 
echo Don't be stupid! Win9x don't know Services 
echo Please use mysql_start.bat instead 
goto exit 

:WinNT 
if exist %windir%\my.ini GOTO CopyINI 
if exist c:\my.cnf GOTO CopyCNF 
if not exist %windir%\my.ini GOTO MainNT 
if not exist c:\my.cnf GOTO MainNT 

:CopyINI 
echo Safe the %windir%\my.ini as %windir%\my.ini.old! 
copy %windir%\my.ini /-y %windir%\my.ini.old 
del %windir%\my.ini 
GOTO WinNT 

:CopyCNF 
echo Safe the c:\my.cnf as c:\my.cnf.old! 
copy c:\my.cnf /-y c:\my.cnf.old 
del c:\my.cnf 
GOTO WinNT 

:MainNT 
echo Installing MySQL as an Service 
REM Commented out since that file is missing
REM copy "%cd%\bin\my.cnf" /-y %windir%\my.ini

REM In the following line mysqld was changed to mysqld.exe since otherwise
REM the service name is set as mysqld and xampp-control complains that the
REM service path is different from the expected value
bin\mysqld.exe --install mysql --defaults-file="%cd%\bin\my.ini"

echo Try to start the MySQL deamon as service ... 
net start MySQL 

:exit 
pause
