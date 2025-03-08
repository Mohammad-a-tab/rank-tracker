<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Site;
use App\Models\SiteDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteTest extends TestCase
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
    public function testSiteHasManyASiteDetails(): void
    {
        $this->assertInstanceOf(HasMany::class, $this->site->detail());
        $this->assertInstanceOf(Collection::class, $this->site->detail);
    }
}
