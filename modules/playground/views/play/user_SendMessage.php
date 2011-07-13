<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar_User.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l">Send message</div>
			<div class="pageDesc r">You can send messages to users.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<form action="">
		<table class="formcontainer w90">
			<tr>
				<td class="w10 h2"><label for="msgTo">To</label></td>
				<td class="w80"><input id="msgTo" type="text" class="fullwidth" value="John Appleseed" /></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<p class="tac bm10 tdBlue bold"><a href="#" id="msgRecToggle">or select courses</a></p>
					<div id="courseSelect" class="hidden bm10">
						<!-- prefix: msgCs -->
						<div>
							<p class="msgCsMeta" data-selectTarget="courseContainer">
								<a class="rightSep selectAll" href="#">Select all</a>
								<a class="rightSep selectNone" href="#">Select none</a>
								<a class="selectInverse" href="#">Invert selection</a>
							</p>
							
							<p class="" id="courseContainer">
								<span><input type="checkbox" id="course1" /><label for="course1">List all courses here.</label></span>
								<span><input type="checkbox" id="course2" /><label for="course2">Course 2</label></span>
								<span><input type="checkbox" id="course3" /><label for="course3">Course 3</label></span>
								<span><input type="checkbox" id="course4" /><label for="course4">Course 4</label></span>
								<span><input type="checkbox" id="course5" /><label for="course5">Course 5</label></span>
								<span><input type="checkbox" id="course6" /><label for="course6">Course 6</label></span>
								<span><input type="checkbox" id="course7" /><label for="course7">Course 7</label></span>
								<span><input type="checkbox" id="course8" /><label for="course8">Course 8</label></span>
								<span><input type="checkbox" id="course9" /><label for="course9">Course 9</label></span>
								<span><input type="checkbox" id="course10" /><label for="course10">Course 10</label></span>
							</p>
							
							<p class="msgCsMeta">
								Include <input type="checkbox" id="toStu" /><label for="toStu" class="rightSep">students</label>
								<input type="checkbox" id="toTeach" /><label for="toTeach" class="rightSep">teachers</label>
								<input type="checkbox" id="toPar" /><label for="toPar">parents</label>
							</p>
						</div>
					</div> <!-- courseSelect -->
					<p>
						<input type="checkbox" id="incPar" /><label for="incPar" class="rightSep">Send copy to parents</label>
						<input type="checkbox" id="incAtt" /><label for="incAtt" class="rightSep">Include link to attendance</label>
						<input type="checkbox" id="incCal" /><label for="incCal">Include link to calendar</label>
					</p>
				</td>
			</tr>
			<tr>
				<td class="h2"><label for="msgSubject">Subject</label></td>
				<td><input id="msgSubject" type="text" class="fullwidth" /></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<textarea name="msg" id="msg" cols="30" rows="10" class="fullwidth"></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Send message" class="button" /></td>
			</tr>
		</table>
		</form>
		
	</div><!-- pagecontent -->
	
	<div class="clear"></div>
	

<?php include_once 'footer.php'; ?>