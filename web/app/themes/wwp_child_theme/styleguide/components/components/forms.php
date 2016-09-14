<!--components/components/forms.php-->

<form method="" class="name-form" novalidate>

	<div class="form-group input-wrap text-wrap">
		<label for="text1">Text label</label>
		<input type="text" name="text1" class="form-control text" value="" placeholder="Text placeholder" required>
	</div>

	<div class="form-group input-wrap text-wrap">
		<label for="text2">Text label</label>
		<input type="text" name="text2" class="form-control text" value="" placeholder="Text placeholder with error message" required>
		<p class="label-error">This the error message for Text 2</p>
	</div>

	<fieldset class="form-group inline">
		<legend>Legend for an INLINE fieldset*</legend>
		<div class="form-group input-wrap w10">
			<label for="day">Day</label>
			<input type="number" name="day" id="day" class="form-control number" value="" placeholder="JJ" required>
		</div>
		<div class="form-group input-wrap w10">
			<label for="month">Month</label>
			<input type="number" name="month" id="month" class="form-control number" value="" placeholder="MM" required>
		</div>
		<div class="form-group input-wrap w10">
			<label for="year">Year</label>
			<input type="number" name="year" id="year" class="form-control number" value="" placeholder="AAAA" required>
		</div>
	</fieldset>

	<div class="form-group textarea-wrap description-wrap">
		<label for="description">Text area</label>
		<textarea name="description" id="description" class="text form-control" placeholder="Write your text here"></textarea>
	</div>

	<div class="form-group radio-wrap">
		<input id="radio1" type="radio" name="radioBt" value="radio 1" class="radio" required checked>
		<label for="radio1">This is a radio button </label>
		<input id="radio2" type="radio" name="radioBt" value="radio 2" class="radio" required>
		<label for="radio2">This is a radio button </label>
	</div>

	<div class="form-group checkbox-wrap">
		<input id="check1" type="checkbox" name="checkBox" value="checkbox 1" class="checkbox" required checked>
		<label for="check1">This is a pre-checked checkbox</label>
		<br>
		<input id="check2" type="checkbox" name="checkBox" value="checkbox 1" class="checkbox" required>
		<label for="check2">This is a checkbox</label>
	</div>

	<div class="submitFormField txtcenter">
		<button type="submit" class="btn btn-icon btn-secondary">
			Valider <?php echo \getSvgIcon('arrow_right') ?>
		</button>
	</div>

</form>

<hr>

<span class="subTitle">Visually hidden labels <i class="small">(add ".hide-labels" to your form tag)</i></span><br>
<form method="" class="name-form hide-labels">

	<div class="form-group input-wrap firstname-wrap">
		<label for="firstname">Prénom</label>
		<input type="text" name="firstname" id="firstname" class="form-control text" value="" placeholder="Prénom*">
	</div>

	<div class="form-group input-wrap name-wrap">
		<label for="name">Prénom</label>
		<input type="text" name="name" id="name" class="form-control text" value="" placeholder="Nom*">
	</div>

</form>

<hr>

<span class="subTitle">Inline form <i class="small">(add ".form-inline" to your form tag)</i></span><br>
<form class="form-inline">
	<div class="form-group input-wrap">
		<label for="exampleInputEmail3">Email address</label>
		<input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
	</div>
	<div class="form-group input-wrap">
		<label for="exampleInputPassword3">Password</label>
		<input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
	</div>
	<div class="form-group checkbox-wrap">
		<input id="check3" type="checkbox" name="checkInline" value="checkbox 1" class="checkbox" required>
		<label for="check3">Remember me</label>
	</div>

	<button type="submit" class="btn btn-secondary">Sign in</button>
</form>
