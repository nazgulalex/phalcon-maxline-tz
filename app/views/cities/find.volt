<h1>Город::ОК</h1>
{{ form("method":"post") }}
    <p>
        Город: {{ text_field('city') }}
        {{ submit_button('ОК') }}
    </p>
    <p>		
        {{ link_to('/', "Пойду домой") }} - 
        {{ link_to('/cities/list/', "Что ещё есть на складе?") }}
    </p>
{{ end_form() }}