<?php

namespace Modules\Contract\Infrastructure\Repositories\Eloquent\Contracts;

use Modules\Contract\Domain\Models\Contract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Contract\Infrastructure\Repositories\BaseRepositoryInterface;

/**
 * Interface ContractRepository
 * @package Modules\Contract\Infrastructure\Repositories\Eloquent\Concretions
 */
interface ContractRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Returns a collection of contracts by given Ids for specified user type when they(contracts) are not unpaid.
     *
     * @param int $userId
     * @param int $userType
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllAssignedContractsWhereNotUnpaid(int $userId, int $userType, array $filters = []): LengthAwarePaginator;

    /**
     * Returns a collection of contracts that DCM Manager role have been assigned to contract and contract_user role.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllContractsThatDcmManagerHaveBeenAssigned(array $filters = []): LengthAwarePaginator;

    /**
     * Returns a collection of contracts by given Ids for specified user type.
     *
     * @param int $userId
     * @param int $userType
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllAssignedContracts(int $userId, int $userType, array $filters = []): LengthAwarePaginator;

    /**
     * Returns a collection of contracts.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllContracts(array $filters = []): LengthAwarePaginator;

    /**
     * Updates contract's payment_status where its un-paid by contract identifier.
     *
     * @param int $contractId
     * @return int
     */
    public function updateContractPaymentStatusToInstallmentPayment(int $contractId): int;


    /**
     * Gets all the tasks for the given contract identifier.
     *
     * @param int $contractId
     * @return Contract|null
     */
    public function getTasksByContractId(int $contractId): ?Contract;

    /**
     * Gets all the tasks assigned to user for the given contract and user identifier and user type.
     *
     * @param int $contractId
     * @param int $userId
     * @param int $userType
     * @return Contract|null
     */
    public function getUserTasksByContractId(int $contractId, int $userId, int $userType): ?Contract;

    /**
     * Gets all the tasks assigned to user for the given contract and user identifier and user type.
     *
     * @param int $contractId
     * @param int $userId
     * @param int $userType
     * @return Contract|null
     */
    public function getUserAssignedTasksByContractId(int $contractId, int $userId, int $userType): ?Contract;

    /**
     * Gets all the tasks assigned to user for the given contract and user identifier and user type.
     *
     * @param int $contractId
     * @return Contract|null
     */
    public function getAssignedContractByContractId(int $contractId): ?Contract;

    /**
     * Gets all the tasks assigned to user for the given contract and user identifier and user type.
     *
     * @param int $contractId
     * @return Contract|null
     */
    public function getContractUserData(int $contractId): ?Contract;

    /**
     * Get contract data for show in step 6 by contract id.
     *
     * @param int $contractId
     * @return Contract|null
     */
    public function getContractData(int $contractId): ?Contract;
}
