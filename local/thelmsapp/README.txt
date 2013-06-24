Installation Requirements

	▪	Apache 2.x and above
	▪	PHP 5.x and above
	▪	MySQL 5.x and above
	▪	Moodle 2.2-2.4. Download Moodle from the moodle website

Installation instructions

Step 1 - Register
Be sure that you have registered your LMS installation at www.thelmsapp.com/signup 
Your registration will be activated within 24h tops and when it does you will receive a welcome email.

Step 2 - Download the plugin
Download the plugin and place the zip file inside the blocks directory of your Moodle installation. Unzip it and you should now have the plugin folder expanded.
Alternatively you can pull the source directly from github by issuing the following command inside the blocks directory of your moodle installation.

git clone https://github.com/thelmsapp/thelmsapp-plugin-moodle.git

Download https://github.com/thelmsapp/thelmsapp-plugin-moodle-extra-files/archive/master.zip and place "thelmsapp" folder inside your moodle's "local" folder

Step 3 - Download the theme
Next step is to download the accompanying theme. If you have moodle 2.2 or 2.3 download this .zip (or visit this repo), if you have moodle 2.4 download this .zip (or visit this repo).  Place the .zip file inside the themes directory of your Moodle installation. Unzip it and you should now have the theme's folder expanded.

Step 4 - Set up the plugin
Login as administrator and navigate to Site Administration->Notifications.
If everything is OK, you must see a screen informing you that your Moodle installation has detected the new plugin. Click the button 'Upgrade Moodle database now'.

Step 5 - Set up the theme
Set up a rule so that TheLMSapp uses the theme you installed in Step 2. Go to Site Administration --> Appearance --> Themes --> Theme Settings and go to the end of this page. Under "Device detection regular expressions" option enter for Regular expression "*thelmsapp_v1*" and in the Return value field enter "thelmsapp".
Click on save changes and go to Site Administration --> Appearance --> Themes --> Theme selector. Apart from the default options (default, mobile, tablet etc) you will now have a new option called Thelmsapp. Click on change theme and from the new screen navigate to Bootstrap_thelmsapp and click on "Use theme". You have now set the theme to be used by TheLMSapp while you can select any other theme you like for when people are accessing your LMS from a tablet device.

Step 6 - Enable the web services in moodle
After you see the success message continue with the installation as follows:

	1. Browse from the Settings Block to Site Administration -> Advanced features. There you must check the option Enable web services.
	2. Browse from the Settings Block to Site Administrator ->Plugin -> Web Services -> Overview. In the Users as clients with token Section you must click in step 1 and step 2 and do the following.
	3. In step 1 click on the Enable web services link and in the next screen you must check the option Enable Web Services and save the changes by clicking the Save Changes button.
	4. In step 2 click on the Enable protocols link and in the next screen you must enable the REST protocol. Then save the changes by clicking the Save Changes button.
	5. Finally you must browse from the Settings Block to Site Administration -> Users -> Permissions -> Define Roles. There you must select the Authenticated user and then click on the Edit Button. From the Capability list you must find the webservice:createtoken and webservice:restuse and give them the permission allow, select Save Changes button.

Step 7 - Make the plugin's block visible
Navigate to Navigation-> SiteHome.
On the left-hand side of your screen there is a Settings block. Click 'FrontPage Settings' -> 'Turn Editing On'.
Scroll at the bottom of the screen and spot the 'Add a block' selectBox. From the dropdown select the option 'TheLMSApp'. Then click 'Turn Editing Off' from the 'Settings' block.  
You should now have TheLMSApp block installed.
From this block you can manage the Course Hierarchy (Course Categories and Courses), the Buttons appearing in the frontend, your Leads (potential customers), your Newsletter Subscribers and via Services the parts of the information currently exposed in the mobile front-end.

You are done!
If you made it this far congratulations! You have made your LMS installation accessible from TheLMSapp!

After you install the plugin please read the How-to-setup guide in order to learn how you can customize your content for TheLMSapp.

Need some help? Run into any problems? Add an issue and we will get back to you. 

Copyright 2013 TheLMSapp
Licensed under the Apache License, Version 2.0 (the "License"); you may not use this work except in compliance with the License. You may obtain a copy of the License in the LICENSE file, or at:
http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
