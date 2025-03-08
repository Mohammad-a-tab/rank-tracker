<?php

namespace Modules\Contract\Infrastructure\Repositories\Eloquent\Concretions;

use Modules\Contract\Domain\Models\Contract;
use Modules\Contract\Domain\Models\Enums\ContractEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Contract\Domain\Models\Enums\ContractUserEnum;
use Modules\Contract\Infrastructure\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Contract\Infrastructure\Repositories\Eloquent\Contracts\ContractRepositoryInterface;

class ContractRepository extends EloquentBaseRepository implements ContractRepositoryInterface
{
    public function model(): string
    {
        return Contract::class;
    }

    /**
     * @inheritDoc
     */
    public function getAllAssignedContractsWhereNotUnpaid(int $userId, int $userType, array $filters = []): LengthAwarePaginator
    {
        $contracts = $this->model->query()->filter($filters)
            ->whereHas('contractUsers', function ($query) use ($userId, $userType) {
                $query
                    ->where('user_id', $userId)
                    ->where('type', $userType)
                    ->where('status', ContractUserEnum::STATUS_ACTIVE);
            })
            ->whereNot('payment_status', ContractEnum::PAYMENT_STATUS_UNPAID)
            ->with(['creator', 'user', 'office', 'contractTemplate', 'contractUsers.user'])
            ->orderByDesc('id');

        return $contracts->paginateFilter();
    }

    /**
     * @inheritDoc
     */
    public function getAllContractsThatDcmManagerHaveBeenAssigned(array $filters = []): LengthAwarePaginator
    {
        $contracts = $this->model->query()->filter($filters)
            ->whereHas('contractUsers', function ($query) {
                $query
                    ->where('type', ContractUserEnum::TYPE_DCMM)
                    ->where('status', ContractUserEnum::STATUS_ACTIVE);
            })
            ->with(['creator', 'user', 'office', 'contractTemplate', 'contractUsers.user'])
            ->orderByDesc('id');

        return $contracts->paginateFilter();
    }

    /**
     * @inheritDoc
     */
    public function getAllAssignedContracts(int $userId, int $userType, array $filters = []): LengthAwarePaginator
    {
        $contracts = $this->model->query()->filter($filters)
            ->whereHas('contractUsers', function ($query) use ($userId, $userType) {
                $query
                    ->where('user_id', $userId)
                    ->where('type', $userType)
                    ->where('status', ContractUserEnum::STATUS_ACTIVE);
            })
            ->with(
                [
                    'creator',
//                    'contractType',
                    'transactions',
                    'transactions.installments',
                    'user',
                    'office',
                    'contractTemplate',
                    'contractUsers.user'
                ]
            )
            ->orderByDesc('id');

        return $contracts->paginateFilter();
    }

    /**
     * @inheritDoc
     */
    public function getAllContracts( array $filters = []): LengthAwarePaginator
    {
        $contracts = $this->model->query()->filter($filters)
            ->with(
                [
                    'creator',
                    'contractType',
                    'transactions',
                    'transactions.installments',
                    'user',
                    'office',
                    'contractTemplate',
                    'contractUsers.user'
                ]
            )
            ->orderByDesc('id');

        return $contracts->paginateFilter();
    }

    /**
     * @inheritDoc
     */
    public function updateContractPaymentStatusToInstallmentPayment(int $contractId): int
    {
        return $this->model->query()
            ->where('id', $contractId)
            ->where(function ($query) {
                $query
                    ->where('payment_status', ContractEnum::PAYMENT_STATUS_UNPAID)
                    ->orWhereNull('payment_status');
            })
            ->update([
                'payment_status' => ContractEnum::PAYMENT_STATUS_INSTALLMENT_PAYMENT
            ]);
    }

    /**
     * @inheritDoc
     */
    public function getTasksByContractId(int $contractId): ?Contract
    {
        return $this->model->query()
            ->where('id', $contractId)
            ->with(['user', 'boardSteps.tasks.taskUser.assignee', 'boardSteps.tasks.taskUser.reporter'])
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function getUserTasksByContractId(int $contractId, int $userId, int $userType): ?Contract
    {
        return $this->model->query()
            ->where('id', $contractId)
            ->whereHas('contractUsers', function ($query) use ($userId, $userType) {
                $query
                    ->where('user_id', $userId)
                    ->where('type', $userType)
                    ->where('status', ContractUserEnum::STATUS_ACTIVE);
            })
            ->with(['user', 'boardSteps.tasks.taskUser.assignee', 'boardSteps.tasks.taskUser.reporter'])
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function getUserAssignedTasksByContractId(int $contractId, int $userId, int $userType): ?Contract
    {
        return $this->model->query()
            ->where('id', $contractId)
            ->whereHas('contractUsers', function ($query) use ($userId, $userType) {
                $query
                    ->where('user_id', $userId)
                    ->where('type', $userType)
                    ->where('status', ContractUserEnum::STATUS_ACTIVE);
            })
            ->with([
                'user',
                'boardSteps' => function ($query) use ($userId, $userType) {
                    $query->whereHas('tasks.taskUser', function ($query) use ($userId, $userType) {
                        $query
                            ->where(function ($query) use ($userId, $userType) {
                                $query->where('assignee_id', $userId)->where('assignee_type', $userType);
                            })
                            ->orWhere(function ($query) use ($userId, $userType) {
                                $query->where('reporter_id', $userId)->where('reporter_type', $userType);
                            });
                    })->with('tasks.taskUser', 'tasks.taskUser.assignee', 'tasks.taskUser.reporter');
                }
            ])->first();
    }

    /**
     * @inheritDoc
     */
    public function getAssignedContractByContractId(int $contractId): ?Contract
    {
        return $this->model->query()
            ->where('id', $contractId)
            ->with([
                'user',
                'creator',
                'office',
                'contractType',
                'contractUsers',
                'contractUsers.user',
            ])
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function getContractUserData(int $contractId): ?Contract
    {
        return $this->model->query()
            ->where('id', $contractId)
            ->with([
                'user',
                'user.parent'
            ])
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function getContractData(int $contractId): ?Contract
    {
        return $this->model->query()
            ->where('id', $contractId)
            ->with([
                'office',
                'user',
                'user.parent',
                'contractType'
            ])
            ->first();
    }
}
