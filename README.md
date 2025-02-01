# LARA CLINICAL MED

## Dev

### Copy default env

```shell
cp .env.example .env
```

### Configuring A Bash Alias

```shell
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```


### start application

```shell
sail up -d
```


### Key generate

```shell
sail artisan key:generate
```


### Execute seeds

```shell
sail artisan db:seed
```