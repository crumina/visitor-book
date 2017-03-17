<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 */
class Tag
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $note_tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->note_tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     * @return Tag
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add note_tags
     *
     * @param \AppBundle\Entity\NoteTag $noteTags
     * @return Tag
     */
    public function addNoteTag(\AppBundle\Entity\NoteTag $noteTags)
    {
        $this->note_tags[] = $noteTags;

        return $this;
    }

    /**
     * Remove note_tags
     *
     * @param \AppBundle\Entity\NoteTag $noteTags
     */
    public function removeNoteTag(\AppBundle\Entity\NoteTag $noteTags)
    {
        $this->note_tags->removeElement($noteTags);
    }

    /**
     * Get note_tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNoteTags()
    {
        return $this->note_tags;
    }
}
