<?php 
$type=$_GET['type'];

if($type == 'Monthly'){
?>


<p>
	<label>Auto Generate?</label>
	<span class="formwrapper">
		<input type="radio" name="auto_generate" value="1"> Yes &nbsp; &nbsp;
		<input type="radio" name="auto_generate" value="0" checked="checked"> No &nbsp; &nbsp;
	</span>
</p>

<?php 
}else{?>
<input type="hidden" name="auto_generate" value="0" />
<?php }
?>