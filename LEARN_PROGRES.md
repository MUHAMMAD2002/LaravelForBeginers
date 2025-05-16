# Сжатие файлов CSS и JS

- Это код решает, **как подключить стили и скрипты** (CSS / JS)
	- 🛠**В режиме разработки** - используется Vite Dev Server **(не сжатые файлы `app.9f1c3c.js`)**.
	- 🌍**В продакшн** - подключает минифицированные файлы **(сжатые файлы `app.js`)**.
	- **Если ничего не найдено** - показывает встроенные стили.


```blade
@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <style>
        <!-- Резервный CSS-код -->
    </style>
@endif
```

- if files `manifest.json` or `public/hot` exitsts:
	- yes
		- calling Blade method `@vite`
			- Laravel searches `app.js` and `app.css`
			- Connect's right version:
				- `localhost` **(on 🛠 development)** (uncompress files)
				- `public/build/app.[hash].js` **(on 🌍 prodaction)** (compress files)
	- no
		- loads default styles

- `build/manifest.json` - 
  📑 **Cлужебный файл**, создается автоматически, когда запускаешь `npm run build`
	- ❓ **Зачем он нужен?**
		- Laravel не знает сам по себе, как называются сжатые файлы (после сборки у них появляются уникальные имена: `app.9f1c3c.js`)
		- По этому `manifest.json` хранит соответствие между оригинальными (`app.js`) и сжатыми файлами (`app.9f1c3c.js`)
	- 🔸 **Как Laravel использует `manifest.json`**
		- Когда ты пишешь в Blade `@vite(['resources/js/app.js','resources/js/app.css'])`
		- Laravel:
			- ✔ **Проверяет** `public/build/manifest.json`
			- 👀 **Смотрит**, какому сжатому файлу соответствует `app.js` и `app.css`
			- 🔗 **Подключает** уже сжатые и оптимизированные файлы с правильными именами (`app.9f1c3c.js`, `app.9f1c3c.css`)
- `public_path('hot')` - 
  Возвращает файл `public/hot` в которой указан адрес локального сервера Vite: `http://localhost:5173`.
	- **Для чего он нужен?**
		- Laravel по этому файлу понимает:
			- Мы в режиме **🛠 разработки**.
			- Нужно подключить CSS/JS не из `public/build` *(сжатые файлы)*, а напрямую с **Vite Dev Server** *(не сжатые: `resources/css` `resources/js`)*
				- 💻**Vite Dev Server** - Это локальный сервер для разработки. 
					- **Быстро обновлять сайты** при изменении файлов
					- **Мгновенная компиляция** Tailwind, Vue, React и т.д.
					- **Показывает ошибки** в браузере.
					- **Упростить процесс работы** с фронтендом
					- **Мгновенно применять CSS/JS** без полной перезагрузки страницы
