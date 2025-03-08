<?php

namespace Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;
use App\Models\Site;
use App\Models\SiteDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteDetailTest extends TestCase
{
    use RefreshDatabase;

    private Site $site;
    private SiteDetail $siteDetail;
    public function runSeeders(): void
    {
        parent::runSeeders();

        $this->site          = Site         ::factory()->createOne();
        $this->siteDetail    = SiteDetail   ::factory()->createOne(['site_id' => $this->site->id]);
    }

    public function testSiteDetailBelongsToSite()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->siteDetail->site());

        $this->assertInstanceOf(Site::class, $this->siteDetail->site);
    }

}
