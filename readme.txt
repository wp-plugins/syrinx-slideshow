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

= 1.0 =
* First version for wordpress.  Still working on editor functionality with layers.

= 1.0.1 =
* Fixed bug of raw calls to console.log which failed in IE9 and earlier.

= 1.0.2 =
* Fixed the add new button on slideshow admin page so that it really works.  
* Fixed the delete link for each slideshow in table on admin page so that it really deletes the slideshow.

= 1.0.3 =
* Fixed issue with slideshow admin menu link being broken

= 1.0.4 =
* Added new option to jquery control to allow the player controls start off hidden rather than open.

= 1.0.5 =
* Finished the delete slide support in editor.  You can now properly select a slide and then delete it.  Of course you
still need to save the edited slideshow in order for the changes to be made for good and visible to the other users of the site.

= 1.0.6 =
* Change code so that it uses custom post types rather than flat files for slideshow html. Note that upgrading to this version will remove any custom
slideshows created that were stored in the plugins/syrinx-slideshow/slideshows directory.  It is important to copy that folder someplace
and upgrade and copy the files from that folder back afterwards.

= 1.0.7 =
* Changed code so that if there are slideshow files in the slideshow plugin directory, it would move them to posts and delete the file.
* If you created content with post 1.0.6 versions, this version can take the files in the slideshows directory and move them into posts in
the wordpress db.  