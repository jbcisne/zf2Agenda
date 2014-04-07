<?php
/**
 * File for class QualitativoStructObterMedidaInstitucionalPorIniciativa
 * @package Qualitativo
 * @subpackage Structs
 * @author Mikaël DELSOL <contact@wsdltophp.com>
 * @version 20131207-01
 * @date 2014-01-04
 */
/**
 * This class stands for QualitativoStructObterMedidaInstitucionalPorIniciativa originally named obterMedidaInstitucionalPorIniciativa
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://testews.siop.gov.br:443/services/WSQualitativo?wsdl}
 * @package Qualitativo
 * @subpackage Structs
 * @author Mikaël DELSOL <contact@wsdltophp.com>
 * @version 20131207-01
 * @date 2014-01-04
 */
class QualitativoStructObterMedidaInstitucionalPorIniciativa extends QualitativoWsdlClass
{
	/**
	 * The credencial
	 * Meta informations extracted from the WSDL
	 * - minOccurs : 0
	 * @var QualitativoStructCredencialDTO
	 */
	public $credencial;
	/**
	 * The exercicio
	 * Meta informations extracted from the WSDL
	 * - minOccurs : 0
	 * @var int
	 */
	public $exercicio;
	/**
	 * The codigoPrograma
	 * Meta informations extracted from the WSDL
	 * - minOccurs : 0
	 * @var string
	 */
	public $codigoPrograma;
	/**
	 * The codigoObjetivo
	 * Meta informations extracted from the WSDL
	 * - minOccurs : 0
	 * @var string
	 */
	public $codigoObjetivo;
	/**
	 * The codigoIniciativa
	 * Meta informations extracted from the WSDL
	 * - minOccurs : 0
	 * @var string
	 */
	public $codigoIniciativa;
	/**
	 * The codigoMomento
	 * Meta informations extracted from the WSDL
	 * - minOccurs : 0
	 * @var int
	 */
	public $codigoMomento;
	/**
	 * Constructor method for obterMedidaInstitucionalPorIniciativa
	 * @see parent::__construct()
	 * @param QualitativoStructCredencialDTO $_credencial
	 * @param int $_exercicio
	 * @param string $_codigoPrograma
	 * @param string $_codigoObjetivo
	 * @param string $_codigoIniciativa
	 * @param int $_codigoMomento
	 * @return QualitativoStructObterMedidaInstitucionalPorIniciativa
	 */
	public function __construct($_credencial = NULL,$_exercicio = NULL,$_codigoPrograma = NULL,$_codigoObjetivo = NULL,$_codigoIniciativa = NULL,$_codigoMomento = NULL)
	{
		parent::__construct(array('credencial'=>$_credencial,'exercicio'=>$_exercicio,'codigoPrograma'=>$_codigoPrograma,'codigoObjetivo'=>$_codigoObjetivo,'codigoIniciativa'=>$_codigoIniciativa,'codigoMomento'=>$_codigoMomento));
	}
	/**
	 * Get credencial value
	 * @return QualitativoStructCredencialDTO|null
	 */
	public function getCredencial()
	{
		return $this->credencial;
	}
	/**
	 * Set credencial value
	 * @param QualitativoStructCredencialDTO $_credencial the credencial
	 * @return QualitativoStructCredencialDTO
	 */
	public function setCredencial($_credencial)
	{
		return ($this->credencial = $_credencial);
	}
	/**
	 * Get exercicio value
	 * @return int|null
	 */
	public function getExercicio()
	{
		return $this->exercicio;
	}
	/**
	 * Set exercicio value
	 * @param int $_exercicio the exercicio
	 * @return int
	 */
	public function setExercicio($_exercicio)
	{
		return ($this->exercicio = $_exercicio);
	}
	/**
	 * Get codigoPrograma value
	 * @return string|null
	 */
	public function getCodigoPrograma()
	{
		return $this->codigoPrograma;
	}
	/**
	 * Set codigoPrograma value
	 * @param string $_codigoPrograma the codigoPrograma
	 * @return string
	 */
	public function setCodigoPrograma($_codigoPrograma)
	{
		return ($this->codigoPrograma = $_codigoPrograma);
	}
	/**
	 * Get codigoObjetivo value
	 * @return string|null
	 */
	public function getCodigoObjetivo()
	{
		return $this->codigoObjetivo;
	}
	/**
	 * Set codigoObjetivo value
	 * @param string $_codigoObjetivo the codigoObjetivo
	 * @return string
	 */
	public function setCodigoObjetivo($_codigoObjetivo)
	{
		return ($this->codigoObjetivo = $_codigoObjetivo);
	}
	/**
	 * Get codigoIniciativa value
	 * @return string|null
	 */
	public function getCodigoIniciativa()
	{
		return $this->codigoIniciativa;
	}
	/**
	 * Set codigoIniciativa value
	 * @param string $_codigoIniciativa the codigoIniciativa
	 * @return string
	 */
	public function setCodigoIniciativa($_codigoIniciativa)
	{
		return ($this->codigoIniciativa = $_codigoIniciativa);
	}
	/**
	 * Get codigoMomento value
	 * @return int|null
	 */
	public function getCodigoMomento()
	{
		return $this->codigoMomento;
	}
	/**
	 * Set codigoMomento value
	 * @param int $_codigoMomento the codigoMomento
	 * @return int
	 */
	public function setCodigoMomento($_codigoMomento)
	{
		return ($this->codigoMomento = $_codigoMomento);
	}
	/**
	 * Method called when an object has been exported with var_export() functions
	 * It allows to return an object instantiated with the values
	 * @see QualitativoWsdlClass::__set_state()
	 * @uses QualitativoWsdlClass::__set_state()
	 * @param array $_array the exported values
	 * @return QualitativoStructObterMedidaInstitucionalPorIniciativa
	 */
	public static function __set_state(array $_array,$_className = __CLASS__)
	{
		return parent::__set_state($_array,$_className);
	}
	/**
	 * Method returning the class name
	 * @return string __CLASS__
	 */
	public function __toString()
	{
		return __CLASS__;
	}
}
?>