<h2><?php echo $title; ?></h2>
 

 
<?php echo form_open('news/create'); ?>    
    <table>
        <tr>
            <td><label for="title">Title</label></td>
            <td><input type="input" name="title" size="50" />
				<span><?php echo form_error('title');?></span>
			</td>

        </tr>
        <tr>
            <td><label for="text">Text</label></td>
            <td><textarea name="text" rows="10" cols="40"></textarea>
				<span><?php echo form_error('text');?></span>
			</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Create news item" /></td>
        </tr>
    </table>    
</form>
