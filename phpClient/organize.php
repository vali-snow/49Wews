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
	<script language="JavaScript" type="text/javascript" src="../js/organize.js"></script>
</head>
<body>
    <nav></nav>
    <middle>
        <aside></aside>
        <section id="organize">
            <article>
                <table></table>
            </article>
			<modalOrganize>
				<div class="modal-content">
					<div class="modal-header">
						<span class="close">&times;</span>
						<h2>Modal Header</h2>
					</div>
					<div class="modal-body">
						Name:<br><input type="text" name="name">
						Description:<br><input type="text" name="description">
						Link:<br><textarea rows="7" name="link"></textarea>
					</div>
					<div class="modal-footer">
						<button id="submit" type="button">Add Feed</button>
						<button id="reset" type="button">Reset</button>
						<button id="close" type="button">Close</button>
					</div>
				</div>
			</modalOrganize>
		</section>
    </middle>
    <footer></footer>
</body>
</html>