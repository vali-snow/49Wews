<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>DV FeedReader Beta</title>
    <link href="https://fonts.googleapis.com/css?family=Ceviche+One|Exo+2:400i" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/sections.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="../js/common.js"></script>
    <script language="JavaScript" type="text/javascript" src="../js/readFeeds.js"></script>
</head>
<body>
    <nav></nav>
    <middle>
        <aside></aside>
        <section id="readFeeds">
			<div>
				<form id="feeds">
					<p>Select a feed:</p>
					<select></select>
				</form>
				<form id="dateFilter">
					<p>Filter date:</p>
					<select>
						<option value="1">From today</option>
						<option value="2">From last 2 Days</option>
						<option value="7">From last 7 Days</option>
						<option value="ALL" selected>All articles</option>
					</select>
				</form>
			</div>
        </section>
    </middle>
    <footer></footer>
</body>
</html>