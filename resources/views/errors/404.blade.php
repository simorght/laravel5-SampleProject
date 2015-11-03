<html>
	<head>
		<link href='https://fonts.googleapis.com/css?family=Scheherazade&subset=arabic,latin' rel='stylesheet' type='text/css'>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Scheherazade', serif;
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 72px;
				margin-bottom: 40px;
			}
		</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">این صفحه وجود ندارد</div>
                <a href="{!! url('/') !!}" class="btn btn-lg btn-default">{{ trans('layout/missing.button') }}</a>

			</div>
		</div>
	</body>
</html>
