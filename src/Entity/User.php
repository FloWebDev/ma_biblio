<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="app_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("username", message="Identifiant déjà utilisé")
 * @UniqueEntity("email", message="Adresse email déjà utilisée")
 */
class User implements UserInterface, \Serializable, EquatableInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Zà-źÀ-Ź0-9]+$/",
     *     match=true,
     *     message="L'identifiant doit être composé de lettres et chiffres uniquement (et sans espace)."
     * )
     */
    private $username;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=64)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Zà-źÀ-Ź0-9!?*@#_\-.$]+$/",
     *     match=true,
     *     message="Le mot de passe doit être composé de lettres, chiffres et/ou des caractères spéciaux autorisés."
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * 
     * @Assert\File(
     *     maxSize = "1024k",
     *     uploadIniSizeErrorMessage = "L'avatar ne doit pas dépasser une taille de {{ limit }} {{ suffix }}.",
     *     mimeTypes = {"image/png", "image/jpeg"},
     *     mimeTypesMessage = "L'avatar doit être au format PNG ou JPEG"
     * )
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $connected_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="user")
     */
    private $books;

    public function __construct()
    {
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));

        // Valeurs par défaut
        $this->created_at = new \DateTime();
        $this->public = true;
        $this->active = true;
        $this->books = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->username;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof self) {
            return false;
        }

        if ($this->id !== $user->getId()) {
            return false;
        }

        return true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     * @link https://www.php.net/manual/fr/functions.returning-values.php#example-170
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = mb_strtolower($username);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = array();
        // $roles = $this->roles;
        $userRole = $this->getRole()->getCode();
        // guarantee every user at least has ROLE_USER
        $roles[] = $userRole;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = mb_strtolower($email);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /*
     ATTENTION : lorsque je manipule des objets du type "file", je ne peux pas garder 
     les types d'entrée et de retour automatiquement générés par Symfony, qui ocassionent
     la perte du type objet et ses données au profit d'une seule chaine de caractere
     contenant uniquement le path par défaut d'upload de fichier de chez PHP
    */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getConnectedAt(): ?\DateTimeInterface
    {
        return $this->connected_at;
    }

    public function setConnectedAt(?\DateTimeInterface $connected_at): self
    {
        $this->connected_at = $connected_at;

        return $this;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setUser($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            // set the owning side to null (unless already changed)
            if ($book->getUser() === $this) {
                $book->setUser(null);
            }
        }

        return $this;
    }
}
