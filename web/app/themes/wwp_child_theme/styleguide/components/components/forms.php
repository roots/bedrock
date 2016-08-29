<!--components/components/forms.php-->

<form>

	<div class="form-errors">Main error message</div>

 	<div class="form-group">
 	  <label for="exampleInputText1">Text</label>
 	  <input type="email" class="form-control" id="exampleInputText1" placeholder="Your text here">
 	  <p class="help-block">Example block-level help text here.</p>
 	</div>

 	<div class="form-group has-error">
 	  <label for="exampleInputText2">Text with error message</label>
 	  <input type="email" class="form-control" id="exampleInputText2" placeholder="Your text here">
		<label class="label-error" for="exampleInputText2">An email is required</label>
 	</div>

 	<div class="form-group">
 	  <label for="exampleInputEmail1">Email</label>
 	  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Your Email">
 	</div>

 	<div class="form-group">
 	  <label for="exampleInputPassword1">Password</label>
 	  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
 	</div>

 	<div class="form-group">
 	  <label for="exampleInputFile">File input</label>
 	  <input type="file" id="exampleInputFile">
 	</div>
 
 	<div class="form-group checkbox">
 		<label for="isActive">
 			<input type="checkbox" name="isActive" id="isActive" value="1"> 
 			Checkbox
 		</label>
 		<label for="isActive2">
 			<input type="checkbox" name="isActive" id="isActive2" value="2" checked> 
 			Checkbox checked
 		</label>
 	</div>

 	<div class="form-group radio">
		<label>
		  <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
		  Option two can be something else and selecting it will deselect option one
		</label>
 		<label>
 		  <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
 		  Option. This one is checked
 		</label>
	</div>

</form>

<hr>

<span class="subTitle">Inline form <i class="small">(add ".form-inline" to your form tag)</i></span><br>

<form class="form-inline"> 
	<div class="form-group"> 
		<label for="exampleInputEmail3">Email address</label> 
		<input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email"> 
	</div> 
	<div class="form-group"> 
		<label for="exampleInputPassword3">Password</label> 
		<input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password"> 
	</div> 
	<div class="form-group checkbox"> 
		<label> <input type="checkbox"> Remember me </label> 
	</div> 
	<button type="submit" class="btn btn-default">Sign in</button> 
</form>
