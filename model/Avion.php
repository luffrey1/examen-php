<?php 
 class Avion {
    protected ?int $id = null;
    protected String $marca;
    protected String $modelo;
    protected int $maximoPasajeros;
    protected array $pasajeros = [];
    public function __construct(String $marca, String $modelo, int $maximoPasajeros, array $pasajeros){
        $this->id = null;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->maximoPasajeros = $maximoPasajeros;
        $this->pasajeros = $pasajeros;
    }
    public function getId(): int {return $this->id;}

	public function getMarca(): String {return $this->marca;}

	public function getModelo(): String {return $this->modelo;}

	public function getMaximoPasajeros(): int {return $this->maximoPasajeros;}

	public function getPasajeros(): array {return $this->pasajeros;}

	public function setId(int $id): void {$this->id = $id;}

	public function setMarca(String $marca): void {$this->marca = $marca;}

	public function setModelo(String $modelo): void {$this->modelo = $modelo;}

	public function setMaximoPasajeros(int $maximoPasajeros): void {$this->maximoPasajeros = $maximoPasajeros;}

	public function setPasajeros(array $pasajeros): void {$this->pasajeros = $pasajeros;}

	
	
}