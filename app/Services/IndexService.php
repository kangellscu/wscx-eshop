<?php

namespace App\Services;

use Illuminate\Support\Collection;

class IndexService {
    /**
     * Get index page related info
     *
     * @return Collection   items as below:
     *                      - banners Collection
     *                          - image String  banner image url
     *                      - contactImage String
     *                      - brands Collection
     *                          - capital String    首字母 
     *                          - id String
     *                          - name String
     *                      - categories Collection
     *                          - id String     big category id
     *                          - name String
     *                          - subs Collection    small categories
     *                              - id String small category id
     *                              - name String
     *                      - products Collection
     *                          - id String
     *                          - name String
     *                          - thumbnail String
     *                          - materials Collection
     *                              - doc String    url
     */
    public function getIndexInfo() : object {
        // todo
    }
}
