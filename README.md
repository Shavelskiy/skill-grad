#Skill Grad

## Запуск проекта

```
./app.sh down && ./app.sh build && ./app.sh up
``` 

Для запуска на деве запускать с параметром dev, на проде с параметром prod
```
./app.sh build dev
./app.sh build prod
```

## Xdebug
для установки xdebug в контейнер указать параметр x
```
./app.sh build x
```
## Фронт
```
./app.sh front install
```
```
./app.sh front watch
```
```
./app.sh front build
```

## Композер
```
./app.sh composer
```

## Консоль
```
./app.sh console
```

## PHP cs fixer
```
./app.sh php-fixer
```
