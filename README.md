# CorreiosHX - Consulta de CEP diretamente ao site dos correios


## Instalação

+ Instale as dependências via **Composer** com o seguinte comando: `composer require electrolinux/phpquery`, e;
+ Combine a pasta `src` do serviço com a do framework ou copie o arquivo para a pasta: `src/HXPHP/System/Services`.



## Uso

+ Carregue o serviço no **controller**:
```php
$this->load(
    'Services\Correios',
    'http://m.correios.com.br/movel/buscaCepConfirma.do',
    $this->request->get('cep'));
```

+ Armazene os dados, como objeto, em uma variável:
```php
$endereco = json_decode($this->correios->getDados());
```

+ Utilize os parâmetros que deseja:
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
