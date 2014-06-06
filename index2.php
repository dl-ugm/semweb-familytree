<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Semantic Web Assignment &raquo; Sparql Client</title>
	<link rel="stylesheet" href="public/css/main.css">
</head>
<body>
	<div id="container">
		<h1>Semantic Web Assignment <small>Sparql Client</small></h1>
		<form role="form" method="POST" action="getData.php" id="sparql-form">
			<input type="text" placeholder="Type variable name, separate with space" name="theVar" id="theVar">
			<textarea name="query" cols="30" rows="5" placeholder="type your query here" id="query"></textarea>
			<button class="btn-block"><i class="fa fa-search"></i> Search</button>
		</form>
		<hr>
		<div id="result"></div>
	</div>
	<script src="public/js/jquery.js"></script>
	<script>
	$(function(){
		$('#sparql-form').submit(function(e){
			e.preventDefault();
			var ini = $(this);
			var url = ini.attr('action');
			var data = {
				theVar: ini.find('#theVar').val(),
				query: ini.find('#query').val()
			};

			$('#result').empty().html('Loading Results ...').load(url,data);
		});
	});
	</script>
</body>
</html>