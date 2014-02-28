micro-php-file-manager
======================
<br>
Very small, lightweight, feature-lacking application to assist in simple file management on a server.<br>
This tool is intended to mediate repetitive, simple, consistent file operations.<br>
<br>
For example, this application is useful if you:<br>
<ul>
<li>frequently move/copy files from one set directory to another</li>
<li>want to provide limited operations/access to non-technical users</li>
<li>want to perform basic file operations that would otherwise require an FTP client or similar</li>
<li>et cetera.</li>
</ul>

This application is not an all-purpose file management tool.<br>
It is not intended to replace a user's FTP client, cpanel tools, ssh client, etc.<br>
Rather, this application aims to simplify repetitive processes that a user would not want to use a full-sized client for.<br>


<h3>INSTALLATION</h3>
<h4>Step #1</h4>
Download micro-php-file-manager onto the machine on which you want it to run.<br>
If downloaded as an archive, unzip the archive.<br>
<br>
<h4>Step #2</h4>
Navigate into the extracted micro-php-file-manager folder and open settings.php.<br>
There are a few settings you may need to change before continuing.<br><br>
First, you should change dbUser and dbPass. Set these to the username and password of the MySQL user you want to login with.<br>
This user will need to have the ability to create databases, tables, etc.<br><br>
Next, if the database is hosted on another machine, change the value of host.<br><br>
Optionally, you can change dbname to something more suitable. If you do, however, you'll need to change the SQL script to match.<br><br>
<h4>Step #3</h4>
Via MySQL, run db.sql.<br>
If you are logged into MySQL, run "source /path/to/db/db.sql". eg. "source /var/www/micro-php-file-manager/sql/db.sql"<br>
If not, run "mysql -u username -p password < db.sql". eg. "mysql -u root -p toor < sql/db.sql"<br>
You can also execute the commands manually, but this way is much faster.<br><br>
<h4>Step #4</h4>
Delete db.sql (and the empty sql folder, if you want).<br>
After running it successfully, the file is no longer needed. Keeping it in a soon to be shared directory is a bad idea.<br>
This is because the file contains the name of the database you've just created, as well as other pieces of information pertaining to the database, and while this information is generally harmless (and nobody is likely to see it anyway), I'd always advise caution over complacense.<br><br>
<h4>Step #5 (only necessary if you want to require login)</h4>
If you want to require a password to use mphpfm, log into MySQL once more.<br>
Use the newly created database Mover (or whatever you decided to name it) and run insert_user(username, password).<br>
eg. <br>
mysql -u root -p<br>
use database Mover;<br>
select insert_user('MyUser','MyPassword');<br>
exit<br><br>
<h4>Step #6</h4>
Finally, open settings.php once more.<br>
Installation is finished, so now you should tweak the settings to your liking.<br>
For example, if you want to enable access without a password, set loginRequired to false.<br>
<br>
<h4>Done!</h4>
mphpfm is now ready to use. Simply move the folder to somewhere accessible, optionally rename the folder, and you're done.<br>
eg. Move the folder to "/var/www/mydomain/public_html/"" and rename it to "filemanager".<br>
After that you would access mphpfm by going to "mydomain.com/filemanager"