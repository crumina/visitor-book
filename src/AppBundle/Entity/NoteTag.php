<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoteTag
 */
class NoteTag
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Note
     */
    private $note;

    /**
     * @var \AppBundle\Entity\Tag
     */
    private $tag;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set note
     *
     * @param \AppBundle\Entity\Note $note
     * @return NoteTag
     */
    public function setNote(\AppBundle\Entity\Note $note = null)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return \AppBundle\Entity\Note 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set tag
     *
     * @param \AppBundle\Entity\Tag $tag
     * @return NoteTag
     */
    public function setTag(\AppBundle\Entity\Tag $tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \AppBundle\Entity\Tag 
     */
    public function getTag()
    {
        return $this->tag;
    }
}
