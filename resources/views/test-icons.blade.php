<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<style>
		.icon {
			width: 100px;
			height: 100px;
			display: block;
			margin: 0 auto;
		}
		.icon-text {
			display: block;
			text-align: center;
		}
	</style>
</head>
<body>
	<table border="1">
		<tr>
			<th>Код</th>
			<th>Название</th>
			<th>Описание</th>
			<th>День</th>
			<th>Ночь</th>
		</tr>
		@foreach(trans('icons') as $index => $icon)
			<tr>
				<td>{{ $index }}</td>
				<td>{{ $icon['name'] }}</td>
				<td>{{ $icon['description'] }}</td>
				<td>
					@if($icon['day'] ?? false)
						<img class="icon" src="/img/icons/colored-fill/{{ $icon['day'] }}.svg" alt="{{ $icon['day'] }}">
						<span class="icon-text">{{ $icon['day'] }}</span>
					@endif
				</td>
				<td>
					@if($icon['night'] ?? false)
						<img class="icon" src="/img/icons/colored-fill/{{ $icon['night'] }}.svg" alt="{{ $icon['night'] }}">
						<span class="icon-text">{{ $icon['night'] }}</span>
					@endif
				</td>
			</tr>
		@endforeach
	</table>
</body>
</html>
