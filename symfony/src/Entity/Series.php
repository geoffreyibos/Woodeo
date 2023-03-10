<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Series
 *
 * @ORM\Table(name="series", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_3A10012D85489131", columns={"imdb"})})
 * @ORM\Entity
 */
class Series
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="plot", type="text", length=0, nullable=true)
     */
    private $plot;

    /**
     * @var string
     *
     * @ORM\Column(name="imdb", type="string", length=128, nullable=false)
     */
    private $imdb;

    /**
     * @var string|null
     *
     * @ORM\Column(name="poster", type="blob", length=0, nullable=true)
     */
    private $poster;

    /**
     * @var string|null
     *
     * @ORM\Column(name="director", type="string", length=128, nullable=true)
     */
    private $director;

    /**
     * @var string|null
     *
     * @ORM\Column(name="youtube_trailer", type="string", length=128, nullable=true)
     */
    private $youtubeTrailer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="awards", type="text", length=0, nullable=true)
     */
    private $awards;

    /**
     * @var int|null
     *
     * @ORM\Column(name="year_start", type="integer", nullable=true)
     */
    private $yearStart;

    /**
     * @var int|null
     *
     * @ORM\Column(name="year_end", type="integer", nullable=true)
     */
    private $yearEnd;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Country", mappedBy="series")
     */
    private $country = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="series")
     */
    private $user = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Actor", mappedBy="series")
     */
    private $actor = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Genre", mappedBy="series")
     */
    private $genre = array();

    /**
     * @var \Season
     *
     * @ORM\OneToMany(targetEntity="Season", mappedBy="series")
     * @ORM\OrderBy({"number" = "ASC"})
     */
    private $seasons;

    /**
     * @var \ExternalRating
     *
     * @ORM\OneToMany(targetEntity="ExternalRating", mappedBy="series")
     */
    private $rate;

    /**
     * @var \Rating
     *
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="series")
     */
    private $rates;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->country = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actor = new \Doctrine\Common\Collections\ArrayCollection();
        $this->genre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->seasons = new ArrayCollection();
        $this->rates = new ArrayCollection();
        $this->rate = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(?string $plot): self
    {
        $this->plot = $plot;

        return $this;
    }

    public function getImdb(): ?string
    {
        return $this->imdb;
    }

    public function setImdb(string $imdb): self
    {
        $this->imdb = $imdb;

        return $this;
    }

    public function getPoster()
    {
        return $this->poster;
    }

    public function displayPoster() {
        $this->poster = "data:image/png;base64,".base64_encode(stream_get_contents($this->getPoster()));

        return $this->poster;
    }

    public function setPoster($poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(?string $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getYoutubeTrailer(): ?string
    {
        $this->youtubeTrailer = preg_replace('/watch\?v=/','embed/',$this->youtubeTrailer);
        return $this->youtubeTrailer;
    }

    public function setYoutubeTrailer(?string $youtubeTrailer): self
    {
        $this->youtubeTrailer = $youtubeTrailer;

        return $this;
    }

    public function getAwards(): ?string
    {
        return $this->awards;
    }

    public function setAwards(?string $awards): self
    {
        $this->awards = $awards;

        return $this;
    }

    public function getYearStart(): ?int
    {
        return $this->yearStart;
    }

    public function setYearStart(?int $yearStart): self
    {
        $this->yearStart = $yearStart;

        return $this;
    }

    public function getYearEnd(): ?int
    {
        return $this->yearEnd;
    }

    public function setYearEnd(?int $yearEnd): self
    {
        $this->yearEnd = $yearEnd;

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getCountry(): Collection
    {
        return $this->country;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->country->contains($country)) {
            $this->country->add($country);
            $country->addSeries($this);
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        if ($this->country->removeElement($country)) {
            $country->removeSeries($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->addSeries($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            $user->removeSeries($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActor(): Collection
    {
        return $this->actor;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actor->contains($actor)) {
            $this->actor->add($actor);
            $actor->addSeries($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        if ($this->actor->removeElement($actor)) {
            $actor->removeSeries($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
            $genre->addSeries($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genre->removeElement($genre)) {
            $genre->removeSeries($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Season>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function getSeasonsNumber(): int
    {
        return $this->getSeasons()->count();
    }

    public function addSeason(Season $season): self
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->setSeries($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): self
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getSeries() === $this) {
                $season->setSeries(null);
            }
        }

        return $this;
    }

    public function getRate(): ?Collection
    {
        return $this->rate;
    }

    # TODO: fix this
    public function setRate(?Collection $rate): self
    {
        // unset the owning side of the relation if necessary
        if ($rate === null && $this->rate !== null) {
            $this->rate->setSeries(null);
        }

        // set the owning side of the relation if necessary
        if ($rate !== null && $rate->getSeries() !== $this) {
            $rate->setSeries($this);
        }

        $this->rate = $rate;

        return $this;
    }

    public function addExternalRate(ExternalRating $rate): self
    {
        if (!$this->rate->contains($rate)) {
            $this->rate->add($rate);
            $rate->setSeries($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function getNumberRates(): int
    {
        $externals = 0;
        foreach ($this->getRate() as $rate) {
            $externals += $rate->getVotes();
        }
        return $this->rates->count()+$externals;
    }

    public function getMoyRates(): float
    {
        $notes = 0;
        $count = 0;
        foreach ($this->getRate() as $rate) {
            $notes += floatval($rate->getValue())*$rate->getVotes();
            $count += $rate->getVotes();
        }
        foreach ($this->rates as $rate) {
            $notes += $rate->getValue();
            $count++;
        }

        return round($notes/$count, 1);
    }

    public function addRate(Rating $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates->add($rate);
            $rate->setSeries($this);
        }

        return $this;
    }

    public function removeRate(Rating $rate): self
    {
        if ($this->rates->removeElement($rate)) {
            // set the owning side to null (unless already changed)
            if ($rate->getSeries() === $this) {
                $rate->setSeries(null);
            }
        }

        return $this;
    }

    public function getNumEpisodes(EntityManagerInterface $em): int
    {
        $qb = $em->createQueryBuilder();
        $qb->select('COUNT(e.id)')
            ->from(Season::class, 'se')
            ->join('se.episodes', 'e')
            ->where('se.series = :series')
            ->setParameter('series', $this);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getNumberSeasonView(User $user, EntityManagerInterface $em): int
    {
        $result = $em->createQueryBuilder()
            ->select('MAX(se.number)')
            ->from(User::class, 'u')
            ->innerJoin('u.episode', 'ep')
            ->innerJoin('ep.season', 'se')
            ->where('u = :user')
            ->setParameter('user', $user)
            ->andWhere('se.series = :series')
            ->setParameter('series', $this);
        if (empty($result->getQuery()->getSingleScalarResult())) {
            return 0;
        }
        return $result->getQuery()->getSingleScalarResult();
    }

}
