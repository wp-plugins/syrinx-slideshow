<?php

?>
<input type="hidden" id="uploadField"/>
<div class="syx-slideshow-editor">
    <div class="wrap">
<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
<h2>Slideshows <a href="#" class="add-new-h2 syx-new-slide">Add New</a></h2>
</div>
<div class="tablenav top">
	<div class="alignleft actions">
		<br class="clear">
	</div>
</div>
<table class="wp-list-table widefat fixed media" cellspacing="0">
	<thead>
	<tr>
		<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
        <th scope="col" id="icon" class="manage-column column-icon" style=""></th>
        <th scope="col" id="title" class="manage-column column-title sortable desc" style=""><a href="http://localhost:86/wp-admin/upload.php?orderby=title&amp;order=asc"><span>File</span><span class="sorting-indicator"></span></a></th>
        <th scope="col" id="author" class="manage-column column-author sortable desc" style=""><a href="http://localhost:86/wp-admin/upload.php?orderby=author&amp;order=asc"><span>Author</span><span class="sorting-indicator"></span></a></th>
        <!--
        <th scope="col" id="parent" class="manage-column column-parent sortable desc" style=""><a href="http://localhost:86/wp-admin/upload.php?orderby=parent&amp;order=asc"><span>Attached to</span><span class="sorting-indicator"></span></a></th>
        <th scope="col" id="comments" class="manage-column column-comments num sortable desc" style=""><a href="http://localhost:86/wp-admin/upload.php?orderby=comment_count&amp;order=asc"><span><span class="vers"><img alt="Comments" src="http://localhost:86/wp-admin/images/comment-grey-bubble.png"></span></span><span class="sorting-indicator"></span></a></th>
        -->
        <th scope="col" id="date" class="manage-column column-date sortable asc" style=""><a href="http://localhost:86/wp-admin/upload.php?orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a></th>
    </tr>
	</thead>

	<tbody id="the-list">
    <?php
            $list = syx_getExistingSlideShowIds();
            foreach($list as $sshow) {
                preg_match('/<img src="([^"]*)"/', $sshow['html'], $matches);
                $firstImg = $matches[1];
                $numSlides = preg_match_all('/ksg-slide["\'\w]/', $sshow['html'], $matches);
                //$numSlides = sizeof($matches);
                
    ?>
    	<tr id="post-10" class="alternate author-self status-inherit" valign="top" data-slideshow-id="<?php echo $sshow['id'];?>">
		    <th scope="row" class="check-column"><input type="checkbox" name="media[]" value="10"></th>
		    <td class="column-icon media-icon"><a href="#" class="syx-view" title="Edit “<?php echo $sshow['id'];?>”"><img width="60" src="<?php echo $firstImg;?>" class="attachment-80x60" alt="<?php echo $sshow['id'];?>" title="<?php echo $sshow['id'];?>"></a></td>
            <td class="title column-title">
                <strong><a href="#" class="syx-view" title="Edit “<?php echo $name;?>”"><?php echo $sshow['id'];?></a></strong>
                <p><?php echo $numSlides;?> slides</p>
                <div class="row-actions">
                    <span class="edit"><a class="syx-view" href="#">Edit</a> | </span>
                    <span class="delete"><a class="submitdelete" href="#">Delete Permanently</a> | </span>
                    <span class="view"><a href="/?syx_slideshow=<?php echo $sshow['id']; ?>" title="View “Setup of WordPress site complete”" rel="permalink">View</a></span>
                </div>
            </td>
		    <td class="author column-author"><?php echo $sshow['author']; ?></td>
            <!--
			<td class="parent column-parent"><strong><a href="#"></td>
		    <td class="comments column-comments num">
			    <div class="post-com-count-wrapper"><a href="#" title="0 pending" class="post-com-count"><span class="comment-count">0</span></a></div>
		    </td>
            -->
		    <td class="date column-date"><?php echo $sshow['date']; ?></td>
	    </tr>
    <?php
        }        
    ?>

	</tbody>
</table>


<div class="syx-slideplayer"></div>
</div>

<div class="syx-new-slide-dialog" style="position:absolute;display:none;width:400px">
  <label>New Slide Id:</label>
  <input type="text" id="syx_new_ssId" />
</div>