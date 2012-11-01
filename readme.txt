=== Syrinx Slideshow ===
Contributors: Maryann Denman, Matt Denman
Tags: javascript, slideshow, images
Requires at least: 2.7
Tested up to: 3.4
Stable tag: trunk

Adds a flexible slideshow with editor and various options

== Description ==

Adds a flexible slideshow with editor and various options.  
Please note that this version is still in the works.  I will update this description when the editor is more complete.

1. [Site](http://wordpress.kusog.org)
2. [How To Use Guide](http://wordpress.kusog.org/?p=41)


== Installation ==

1. Upload `syrinx-slideshow` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create slideshows in the new slideshows admin page.

== Screenshots ==

1. screenshot-1.jpg
2. screenshot-2.jpg
3. screenshot-3.jpg

== Changelog ==

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

