# CorreiosHX - Consulta de CEP diretamente ao site dos correios


## Instalação

+ Instale as dependências via **Composer** com o seguinte comando: `composer require electrolinux/phpquery`, e;
+ Copie a pasta `Correios` para a pasta de serviços: `src/HXPHP/System/Services`.

## Uso

+ Carregue o serviço no **controller**:
```php
$this->load(
    'Services\Correios',
    $this->request->get('cep') // 00000-000
);
```

+ Armazene os dados, como objeto, em uma variável:
```php
$retornoJSON = $this->correios->getDados();
$enderecoObj = json_decode($retornoJSON);
```

+ Utilize os parâmetros que desejar:
```
stdClass Object
(
    [logradouro] => Rua Caçapava
    [bairro] => Jardim Paulista
    [cep] => 01408010
    [cidade] => São Paulo
    [uf] => SP
)
```
