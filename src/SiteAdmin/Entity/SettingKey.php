<?php
namespace SiteAdmin\Entity;

use Doctrine\ORM\Mapping as ORM;
use SynergyCommon\Entity\BaseEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SettingKey
 *
 * @ORM\Entity
 * @ORM\Table(name="Setting_Key")
 *
 */
class SettingKey extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=120, unique=true)
     */
    private $title;
    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string")
     */
    private $code;
    /**
     * @ORM\Column(type="string", name="default_value")
     */
    private $defaultValue = '';
    /**
     * @ORM\Column(type="string", length=25, name="input_type")
     */
    private $inputType = 'text';
    /**
     * @ORM\Column(type="string", name="data_source")
     */
    private $dataSource;
    /**
     * @ORM\Column(type="text", name="help_info")
     */
    private $helpInfo;

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function getDataSource()
    {
        return $this->dataSource;
    }

    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function setHelpInfo($helpInfo)
    {
        $this->helpInfo = $helpInfo;
    }

    public function getHelpInfo()
    {
        return $this->helpInfo;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setInputType($inputType)
    {
        $this->inputType = $inputType;
    }

    public function getInputType()
    {
        return $this->inputType;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

}