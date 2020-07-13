<h1>Города</h1>
{% for city in cities%}
	<p>{{ city.city }} ({{ city.lat }}, {{ city.lon }}) добавлен {{ city.timestamp }}</p>
{% endfor %}
	<p>
		{{ link_to('/cities/find/', "Что с погодой?") }} - 
		{{ link_to('/', "Пойду домой!") }}
	</p>