=== Syrinx Slideshow ===
Contributors: Maryann Denman, Matt Denman
Tags: javascript, slideshow, images
Requires at least: 3.9.1
Tested up to: 3.9.1
Stable tag: trunk

Image slideshow that can have multiple animated layers. Includes powerful timeline editor that lets you build your slideshow visually.

== Description ==

1. [Plugin Site](http://wordpress.kusog.org/slideshow-including-powerful-editor/)
2. [Basic Editing Overview](http://wordpress.kusog.org/using-syrinx-slideshow/)
3. [Plugin Documentation List](http://wordpress.kusog.org/category/docs/)

Adds a flexible image slideshow that can be used either as fullpage background slideshow or as just an area within the page.
Each image slide can have multiple animated layers, which use keyframes to allow for complex movement paths. Each slide can be configured to pan and zoom its image background. 
Includes powerful timeline editor that lets you build your slideshow visually, which can be used directly on pages that contain a slideshow
for true a WYSIWYG editing experience.

The slideshow player can do two levels of downgrading its animations based on performance feedback from when the player first starts. 
If the browser cannot keep up with the desired frame-rate within a certain tolerance, then it will stop zoom animation but still pan the background image. 
If the speed of the browser is even more out of a 2nd tolerance, then it will also drop the panning and just switch immediately between slides. 
This level of performance allows the slideshow to work well in limited phone browsers that cannot keep up with that level of animation. 
This has tested well on a Samsung Galaxy phone as well as the Samsung Galaxy 10.1.  The 10.1 is actually slower at the animation than the phone, which is due to the number of pixels being pushed around.
The IPad works well with the animations.  When the slideshow player is used in full screen mode, the controller works well with a touch interface.


== Installation ==

1. Upload `syrinx-slideshow` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create slideshows in the new slideshows admin page.

== Screenshots ==

1. screenshot-1.jpg
2. screenshot-2.jpg
3. screenshot-3.jpg

== Changelog ==
= 1.1.0 =
* Updates to support proper functioning in WordPress 3.9.1

= 1.0.18 =
* Updated links to support documentation.

= 1.0.17 =
* Added fix for adding new slide failing to set image properly for just its own cell.  Adding new slides and setting their image now works as expected.

= 1.0.16 = 
* Another minor fix for leaving code commented out from version 1.0.14.

= 1.0.15 = 
* Fixed bug introduced in 1.0.14 that prevented the slideshow list from showing properly in the admin page.

= 1.0.14 =
* Fixed the broken view link on the slideshow admin page.  It now navigates to a view mode of the post.  This also makes it easier to link to a slideshow directly without having to embed it in a post or use a widget.  Just make the slideshow and use its URL.  
With this option, you can now go into the edit mode of the slideshow post and see the raw html of the post, which can be modified outside the abilities of the editor.
* Added a wordpress specific JS file that helps autobind slideshow markup to the appropriate jQuery plugin.  Previously, each slideshow was pushed into the markup with a little javascript block to kick that specific slideshow off.  This is better.
* Note for future release: Once version 1.1 is released, it will include a minified version of all 3 script files.

= 1.0.13 =
* Updated JavaScript filenames to reflect new versions.

= 1.0.12 =
* Added Upload button to image field in slideshow editor, which will popup the standard image thickbox from wordpress.  This allows images to be
set from wordpress directly rather than needing to use drag/drop like prior versions.
* Added a help link to the left, just below the filmstrip, which will popup a help window to explain how to use the editor.

= 1.0.11 =
* Removed the standard post editor for the syx_slideshow custom post type from the main menu so that only the new Syrinx Slideshow admin page is
shown in the main admin menu.

= 1.0.10 =
* This gives a good view into how editing within the popup slideshow editor window will work.  It is now possible to create a new slide, add a new layer, edit the
content within the layer, add multiple keyframes on the timeline, and then save properly.
* End to End editing of slide, layers, and keyframes popup slideshow editor window is mostly working.  There are still known issues such as deleting keyframes
and there is also a limited set of editing options in the layer at this moment.
* When editing a layer's keyframe animation css, you should check the "Loop" checkbox and also click the "Pause" button, which once paused will have its text change to "Play".
* You can add any css attribute in the well formatted jQuery style css object.
* When you click on a keyframe that lets you see the layer in the slideshow area, you can edit the content in the player within the dashed area.
* Another known issue is that you cannot drag the layer in the layer to set top/left css attributes.  This will be working in near future drop.  As well as using jQuery UI
resize plugin to allow the layer to be resized to the desired width/height.
* Look for future versions to have far more advanced layer content editing options, such as inserting images, videos, post content, etc.

= 1.0.9 =
* Added keframe selection and direct editing of layer content within slideshow area when in edit mode.  Note that the slideshow doesn't pause
automatically when selecting keframes in the editor.  It is easier to edit layers when they are not moving, so use the pause play button to stop the slideshow
before editing.

= 1.0.8 =
* Fixed code to properly set author id of new post to user doing the work - was still hard coded to admin.

= 1.0.7 =
* Changed code so that if there are slideshow files in the slideshow plugin directory, it would move them to posts and delete the file.
* If you created content with post 1.0.6 versions, this version can take the files in the slideshows directory and move them into posts in
the wordpress db.  

= 1.0.6 =
* Change code so that it uses custom post types rather than flat files for slideshow html. Note that upgrading to this version will remove any custom
slideshows created that were stored in the plugins/syrinx-slideshow/slideshows directory.  It is important to copy that folder someplace
and upgrade and copy the files from that folder back afterwards.

= 1.0.5 =
* Finished the delete slide support in editor.  You can now properly select a slide and then delete it.  Of course you
still need to save the edited slideshow in order for the changes to be made for good and visible to the other users of the site.

= 1.0.4 =
* Added new option to jquery control to allow the player controls start off hidden rather than open.

= 1.0.3 =
* Fixed issue with slideshow admin menu link being broken

= 1.0.2 =
* Fixed the add new button on slideshow admin page so that it really works.  
* Fixed the delete link for each slideshow in table on admin page so that it really deletes the slideshow.

= 1.0.1 =
* Fixed bug of raw calls to console.log which failed in IE9 and earlier.

= 1.0 =
* First version for wordpress.  Still working on editor functionality with layers.

