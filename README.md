# m1-display-pending-updates-in-admin

This Project disables running all setup scripts on every request and shows a fancy link in Admin to run the setup 
scripts as needed. A shell script to tigger the updates will be available soon.

# Usage

1. To disable auto update place `<skip_process_modules_updates>true</skip_process_modules_updates>` in your app/etc/local.xml in the config/global node
2. Install via modman
3. You're ready