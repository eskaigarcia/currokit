<?php

namespace Tests\Feature\Database;

use App\Enums\InstanceState as InstanceStateEnum;
use App\Enums\OfferState as OfferStateEnum;
use App\Enums\Priority;
use App\Enums\RewardType;
use App\Models\Achievement;
use App\Models\Board;
use App\Models\BoardCollaborator;
use App\Models\Company;
use App\Models\CompanyEdit;
use App\Models\CompanyInstance;
use App\Models\Flag;
use App\Models\InstanceState;
use App\Models\Offer;
use App\Models\OfferState;
use App\Models\PlatformContent;
use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserContentInteraction;
use App\Models\Vote;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseAdditionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_instance_states_relation_returns_state_models(): void
    {
        $instance = $this->createCompanyInstance();

        $state = InstanceState::create([
            'instance_id' => $instance->id,
            'state' => 'applied',
        ]);

        $loadedState = $instance->states()->sole();

        $this->assertInstanceOf(InstanceState::class, $loadedState);
        $this->assertTrue($loadedState->is($state));
    }

    public function test_offer_states_relation_returns_state_models(): void
    {
        $offer = $this->createOffer();

        $state = OfferState::create([
            'offer_id' => $offer->id,
            'state' => 'interviewing',
        ]);

        $loadedState = $offer->states()->sole();

        $this->assertInstanceOf(OfferState::class, $loadedState);
        $this->assertTrue($loadedState->is($state));
    }

    public function test_user_preferences_are_stored_on_the_users_table(): void
    {
        $user = User::factory()->create();

        $this->assertFalse(Schema::hasTable('user_preferences'));

        $user->setPreference('notifications.email', true);

        $user->refresh();

        $this->assertTrue($user->getPreference('notifications.email'));
        $this->assertSame(
            ['notifications' => ['email' => true]],
            $user->preferences
        );
    }

    public function test_deleting_a_sponsor_nulls_the_platform_content_sponsor(): void
    {
        $author = User::factory()->create();
        $company = Company::create([
            'creator_id' => $author->id,
            'name' => 'Acme',
        ]);

        $content = PlatformContent::create([
            'user_id' => $author->id,
            'sponsor_id' => $company->id,
            'title' => 'Demo Post',
            'slug' => 'demo-post',
            'author' => 'Guest Author',
            'type' => 'article',
        ]);

        $company->delete();

        $this->assertNull($content->fresh()->sponsor_id);
    }

    public function test_deleting_a_board_cascades_collaborators_instances_and_offers(): void
    {
        $instance = $this->createCompanyInstance();
        $collaborator = User::factory()->create();
        $boardCollaborator = BoardCollaborator::create([
            'board_id' => $instance->board_id,
            'user_id' => $collaborator->id,
        ]);
        $offer = Offer::create([
            'company_id' => $instance->company_id,
            'instance_id' => $instance->id,
            'user_id' => $instance->owner_id,
            'position' => 'Engineer',
        ]);
        $boardId = $instance->board_id;
        $instanceId = $instance->id;
        $offerId = $offer->id;
        $boardCollaboratorId = $boardCollaborator->id;

        $instance->board->delete();

        $this->assertSoftDeleted('boards', ['id' => $boardId]);
        $this->assertDatabaseMissing('board_collaborators', ['id' => $boardCollaboratorId]);
        $this->assertSoftDeleted('company_instances', ['id' => $instanceId]);
        $this->assertSoftDeleted('offers', ['id' => $offerId]);
    }

    public function test_board_collaborators_are_unique_per_board_and_user(): void
    {
        $board = Board::create([
            'owner_id' => User::factory()->create()->id,
            'name' => 'Applications',
        ]);
        $collaborator = User::factory()->create();

        BoardCollaborator::create([
            'board_id' => $board->id,
            'user_id' => $collaborator->id,
        ]);

        $this->expectException(QueryException::class);

        BoardCollaborator::create([
            'board_id' => $board->id,
            'user_id' => $collaborator->id,
        ]);
    }

    public function test_votes_are_unique_per_user_and_edit(): void
    {
        [$user, $edit] = $this->createVoteContext();

        Vote::create([
            'user_id' => $user->id,
            'company_edit_id' => $edit->id,
            'value' => 1,
        ]);

        $this->expectException(QueryException::class);

        Vote::create([
            'user_id' => $user->id,
            'company_edit_id' => $edit->id,
            'value' => -1,
        ]);
    }

    public function test_flags_are_unique_per_user_and_edit(): void
    {
        [$user, $edit] = $this->createVoteContext();

        Flag::create([
            'user_id' => $user->id,
            'company_edit_id' => $edit->id,
            'reason' => 'spam',
        ]);

        $this->expectException(QueryException::class);

        Flag::create([
            'user_id' => $user->id,
            'company_edit_id' => $edit->id,
            'reason' => 'duplicate',
        ]);
    }

    public function test_user_achievements_are_unique_per_user_and_achievement(): void
    {
        $user = User::factory()->create();
        $achievement = Achievement::create([
            'title' => 'First Step',
            'reward_type' => RewardType::Badge,
        ]);

        UserAchievement::create([
            'user_id' => $user->id,
            'achievement_id' => $achievement->id,
        ]);

        $this->expectException(QueryException::class);

        UserAchievement::create([
            'user_id' => $user->id,
            'achievement_id' => $achievement->id,
        ]);
    }

    public function test_user_content_interactions_are_unique_per_user_content_and_type(): void
    {
        $user = User::factory()->create();
        $content = PlatformContent::create([
            'user_id' => $user->id,
            'title' => 'Demo Post',
            'slug' => 'demo-post-interaction',
            'author' => 'Guest Author',
            'type' => 'article',
        ]);

        UserContentInteraction::create([
            'user_id' => $user->id,
            'platform_content_id' => $content->id,
            'type' => 'liked',
        ]);

        $this->expectException(QueryException::class);

        UserContentInteraction::create([
            'user_id' => $user->id,
            'platform_content_id' => $content->id,
            'type' => 'liked',
        ]);
    }

    public function test_enum_casts_round_trip_for_database_additions(): void
    {
        $instance = CompanyInstance::create([
            'board_id' => Board::create([
                'owner_id' => User::factory()->create()->id,
                'name' => 'Applications',
            ])->id,
            'company_id' => Company::create([
                'creator_id' => User::factory()->create()->id,
                'name' => 'Acme',
            ])->id,
            'owner_id' => User::factory()->create()->id,
            'current_state' => InstanceStateEnum::Interviewing,
            'priority' => Priority::High,
        ]);

        $offer = Offer::create([
            'company_id' => $instance->company_id,
            'instance_id' => $instance->id,
            'user_id' => $instance->owner_id,
            'position' => 'Engineer',
            'current_state' => OfferStateEnum::OfferReceived,
        ]);

        $achievement = Achievement::create([
            'title' => 'Referral Master',
            'reward_type' => RewardType::PremiumDays,
        ]);

        $this->assertSame(InstanceStateEnum::Interviewing, $instance->fresh()->current_state);
        $this->assertSame(Priority::High, $instance->fresh()->priority);
        $this->assertSame(OfferStateEnum::OfferReceived, $offer->fresh()->current_state);
        $this->assertSame(RewardType::PremiumDays, $achievement->fresh()->reward_type);
    }

    private function createCompanyInstance(): CompanyInstance
    {
        $owner = User::factory()->create();
        $company = Company::create([
            'creator_id' => $owner->id,
            'name' => 'Acme',
        ]);
        $board = Board::create([
            'owner_id' => $owner->id,
            'name' => 'Applications',
        ]);

        return CompanyInstance::create([
            'board_id' => $board->id,
            'company_id' => $company->id,
            'owner_id' => $owner->id,
            'current_state' => InstanceStateEnum::Saved,
            'priority' => Priority::Medium,
        ]);
    }

    private function createOffer(): Offer
    {
        $instance = $this->createCompanyInstance();

        return Offer::create([
            'company_id' => $instance->company_id,
            'instance_id' => $instance->id,
            'user_id' => $instance->owner_id,
            'position' => 'Engineer',
            'current_state' => OfferStateEnum::Saved,
        ]);
    }

    private function createVoteContext(): array
    {
        $user = User::factory()->create();
        $company = Company::create([
            'creator_id' => $user->id,
            'name' => 'Acme',
        ]);
        $edit = CompanyEdit::create([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'field' => 'description',
            'content' => 'Updated text',
        ]);

        return [$user, $edit];
    }
}
