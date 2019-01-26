Задание
---
Запрограммировать страницу регистрации.

Создать БД MySQL с единственной таблицей users.

Поля должны проверяться как на стороне клиента, так и на стороне сервера.
При вводе некорректного значения рядом с полем выводится "восклицательный знак" и сообщение об ошибке.
После ввода корректного значения рядом с полем выводится "галочка", сообщение об ошибке исчезает.

- Никнэйм:
  Должен содержать только латинские буквы и цифры, начинаться должен с латинской буквы.
  Заглавные и прописные символы не различаются, сохранятется в том регистре, в котором был введен.
  Проверяется на существование (в БД) без обновления страницы.

- Имя
  Допустимы только русские буквы.
 
- Фамилия
  Допустимы только русские буквы.
  
- Электронная почта
  Введенное значение должно быть корректным адресом e-mail
  Проверяется на существование (в БД) без обновления страницы.

- Пароль
  Не меньше 5 произвольных символов.

Кнопка "Готово" становится доступной только после того, как все поля заполнены корректно.
Если после этого в поля формы вводится некорректное значение кнопка снова становится неактивной.

После отправки формы данные сохраняются в БД, выдается страница с текстом "Регистрация завершена."

Deploy
---
- Установить Docker
- Запусть `make initialize` в корне проекта

Запуск автотестов
---
Запустить `make run-tests`

Запуск статического анализа кода
---
Запустить `make run-code-analyze`
