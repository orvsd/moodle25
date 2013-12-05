moodle-block_slideshow
======================

#Slideshow block 

###This block creates a slideshow that will appear in the heading section of a course page or front page.

It works with all core moodle themes except "Clean" due to an issue with the theme's ability to load Jquery correctly (MDL-41516)

**Update** With the release of Moodle 2.5.2, MDL-41516 has been fixed and this block will work with Clean theme.

**Tested with:**
* Afterburner
* Anomaly
* Arialist
* Binarius
* Boxxie
* Brick
* Formal White
* FormFactor
* Fusion
* Leatherbound
* Magazine
* Nimble
* Nonzero
* Overlay
* Serenity
* Sky High
* Splash
* Standard

(it may work with some third party themes, but most likely not with any bootstrap based theme due to [MDL-41516](https://tracker.moodle.org/browse/MDL-41516).  If you have a third party theme and it doesn't work, send me a link to your site and I will update the code.)

**Installation:**
Download, extract, and upload the "Slideshow" folder into moodle/blocks

**Global Configuration:**
* Set maximum number of slides in a slideshow
* Set maximum file size of slides

**Instance Configuration:**
* Title - Set title of slideshow  (leave blank to hide block's heading)
* Height - Sets height of slideshow and images **NOTE** this block will not rescale image files, it will only change the display size
* Transition - Choose from various slide transitions (some are a bit clunky, but most work well)
* Delay - Sets the time for which a single slide is displayed
* Background color - Clicking in this textbox triggers a colorpicker
* Transparent - Clicking this overrides the background color setting and makes the background transparent
* Image selector - Will only accept gif, jpg, or png files 
* Use as normal Dock - Will allow the slideshow to be displayed in the side columns or where ever a block can be displayed.
