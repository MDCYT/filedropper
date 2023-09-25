# filedropper.eu <img src="favicon.png" alt="logo" width="25"/>
Secure, fast and temporary file hosting web service wrote in PHP.

### To install
Copy paste the files to your webserver.
Make sure the permission are correct by browsing `check.php`.
If not, edit permission so the webserver owns the files.

*Delete `check.php` once checked*

### For security purposes, don't forget to:
- Block the access to the */tmp* directory from the website
- Block the access to the *log.txt* file from the website

For example, using an .htaccess if you are working with Apache.
If you use an .htaccess in the /tmp directory,
make sure that it won't be deleted when the /tmp directory is emptied.

Delete git relative files/folder is you cloned the repository.

### To empty periodically the /tmp folder
I'll code a bash script later
