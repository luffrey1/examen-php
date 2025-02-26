<?php

class Pasajero {
    protected String $id;
    protected String $nombre;
    protected String $apellidos;
    protected int $edad;
    protected bool $asistencia;
    protected String $contrasena;
   public function __construct(String $id, String $nombre, String $apellidos, int $edad, bool $asistencia, String $contrasena){$this->id = $id;$this->nombre = $nombre;$this->apellidos = $apellidos;$this->edad = $edad;$this->asistencia = $asistencia;$this->contrasena = $contrasena;}
	
   public function getId(): String {return $this->id;}

	public function getNombre(): String {return $this->nombre;}

	public function getApellidos(): String {return $this->apellidos;}

	public function getEdad(): int {return $this->edad;}

	public function getAsistencia(): bool {return $this->asistencia;}

	public function getContrasena(): String {return $this->contrasena;}

	
    public function setId(String $id): void {$this->id = $id;}

	public function setNombre(String $nombre): void {$this->nombre = $nombre;}

	public function setApellidos(String $apellidos): void {$this->apellidos = $apellidos;}

	public function setEdad(int $edad): void {$this->edad = $edad;}

	public function setAsistencia(bool $asistencia): void {$this->asistencia = $asistencia;}

	public function setContrasena(String $contrasena): void {$this->contrasena = $contrasena;}

	
	
}
