# filedropper.ml <img src="favicon.png" alt="logo" width="25"/>
Secure, fast and temporary hosting web service wrote in PHP.

### For security purposes, don't forget to:
- Block the access to the */tmp* directory from the website
- Block the access to the *log.txt* file from the website

For example, using an .htaccess if you are working with Apache.
If you use an .htaccess in the /tmp directory,
make sure that it won't be deleted when the /tmp directory is emptied.

### To empty periodically the /tmp folder
i'll code a bash script later
