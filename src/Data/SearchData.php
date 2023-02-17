<?php

namespace App\Data;

class SearchData
{

    public string | null $q = '';

    public array | null $categories = [];

    public null | \DateTime $datemax;

    public null | \DateTime $datemin;

    public bool $inscrit = false;

    public bool $orga = false;

    public bool $noninscrit = false;
    public bool $passe = false;


}