<?php 

namespace HXPHP\System\Services\Correios;

class Correios
{
	private $html = null;
	private $dados = [];

	public function __construct($url, $cep)
	{
		if (!class_exists('phpQuery'))
			throw new \Exception("Dependencias obrigatorias nao encontradas. Rode o comando: composer require electrolinux/phpquery", 1);
			
		if (!$cep)
			throw new \Exception("CorreiosHX: Informe um CEP valido.", 1);

		$this->setHTML($url, $cep)
				->setDados();
	}

	public function setHTML($url, $cep)
	{
		$this->html = SimplecURL::connect($url, [
			'cepEntrada' => $cep,
			'tipoCep' => '',
			'cepTemp' => '',
			'metodo' => 'buscarCep'
		]);

		return $this;
	}

	public function setDados()
	{
		if (!$this->html)
			throw new \Exception("CorreiosHX: Nao foi possivel obter os dados HTML. Verifique se a primeira etapa do processo foi bem sucedida.", 1);

		\phpQuery::newDocumentHTML($this->html, $charset = 'utf-8');

		$this->dados = [
			'logradouro' => trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
			'bairro' => trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
			'cidade/uf' => trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
			'cep' => trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
		];

		$this->dados['cidade/uf'] = explode('/',$this->dados['cidade/uf']);
		$this->dados['cidade'] = trim($this->dados['cidade/uf'][0]);
		$this->dados['uf'] = trim($this->dados['cidade/uf'][1]);

		unset($this->dados['cidade/uf']);
		
		return $this;
	}

	public function getDados()
	{
		if (!is_array($this->dados) || !$this->dados)
			throw new \Exception("CorreiosHX: Nao foi possivel obter os dados. Verifique se a segunda etapa do processo foi bem sucedida.", 1);

		return json_encode($this->dados);
	}
}