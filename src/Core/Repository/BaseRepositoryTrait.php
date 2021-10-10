<?php
namespace App\Core\Repository;
use App\Core\Datatable\Buttons\SimpleButton;
use App\Core\Datatable\Option\RefLevelOption;
use App\Core\Enum\DataTableEnum;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

trait BaseRepositoryTrait
{
    private array $search;
    private array $orders;
    private array $columns;
    private array $hiddenColumn;
    private array $joins;
    private QueryBuilder $queryBuilder;

    public function dataTable(): array
    {
    $request = $this->requestStack->getCurrentRequest();
    $router=$this->urlGenerator;
    if ($request) {
        $requestQuery = $request->query->all();
        $this->init($requestQuery);
        $draw = $requestQuery['draw'] ?? '1';
        $this->queryBuilder = $this->createQueryBuilder('t')
            ->select($this->selectColumns())
        ;
        $total = $this->createQueryBuilder('t')->select('count(t.id)');
        $filteredTotal = $this->setJoins(clone $total);
        $filteredTotal = $this->setSearch($filteredTotal);
        $this->setOrderBy();
        $this->setPaginationRecords($requestQuery);
        $recordsTotal = $this->getRecordsTotal($total);
        $recordsFiltered = $this->getRecordsFiltered($filteredTotal);
        /**
        TODO DP
         **/
        $results=[];
        foreach ($this->queryBuilder->getQuery()->getScalarResult() as $result){
           $x= new RefLevelOption();
           $result['t_buttons'] =$x->render();
           $results[]=$result;
        }
        return [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $results,
        ];
    }

    return [];
}

    private function init(array $requestQuery): void
{
    $this->search = $requestQuery['search'] ?? [];
    $this->orders = $requestQuery['order'] ?? [];
    $this->columns = $requestQuery['columns'] ?? [];
    $this->hiddenColumn = $requestQuery['hiddenColumn'] ?? [];
    $this->joins = $requestQuery['join'] ?? [];
}

    /**
     * set select columns.
     */
    private function selectColumns(): string
{
    $column = '';
    foreach (\array_merge($this->columns, $this->hiddenColumn) as $colums) {
        if (!isset($colums['searchable']) || (isset($colums['searchable']) && $colums['searchable'] === 'true') && !empty($colums['name']) && \mb_strpos($column, $colums['name']) === false) {
            $column .= $colums['name'] . ' AS ' . $colums['data'] . ',';
        }
    }

    return empty($column) ? 't' : \rtrim($column, ',');
}

    /**
     * set join table to the query.
     */
    private function setJoins(QueryBuilder $filteredTotal): QueryBuilder
{
    foreach ($this->joins as $join) {
        $this->queryBuilder->leftJoin($join['join'], $join['alias'], Expr\Join::WITH, $join['condition']);
        $filteredTotal->leftJoin($join['join'], $join['alias'], Expr\Join::WITH, $join['condition']);
    }

    return $filteredTotal;
}

    /**
     * set order by.
     */
    private function setOrderBy(): void
{
    foreach ($this->orders as $order) {
        $this->queryBuilder->addOrderBy($this->columns[$order['column']]['name'], $order['dir']);
    }
}

    private function setPaginationRecords(array $requestQuery): void
{
    $start = (int) $requestQuery['start'] ?? 0;
    $length = (int) $requestQuery['length'] ?? 50;
    $this->queryBuilder->setFirstResult($start)
        ->setMaxResults($length)
    ;
}

    /**
     * Get List of search.
     */
    private function setSearch(QueryBuilder $filteredTotal): QueryBuilder
{
    $searchlist = [];
    foreach ($this->columns as $column) {
        if ($column['searchable'] === 'true') {
            $searchlist[] = $this->queryBuilder->expr()
                ->like($column['name'], '\'%' . \trim($this->search['value']) . '%\'')
            ;
        }
    }
    foreach ($this->hiddenColumn as $column) {
        $searchlist[] = $this->queryBuilder->expr()
            ->like($column['name'], '\'%' . \trim($this->search['value']) . '%\'')
        ;
    }

    if (!empty($searchlist)) {
        $this->queryBuilder->andWhere(new Expr\Orx($searchlist));
        $filteredTotal->andWhere(new Expr\Orx($searchlist));
    }

    return $filteredTotal;
}

    /**
     * Get number of total records.
     */
    private function getRecordsTotal(QueryBuilder $total): int
{
    try {
        return (int) $total->getQuery()->getSingleScalarResult();
    } catch (NonUniqueResultException $e) {
        return 0;
    }
}

    /**
     * get number of filtred records.
     */
    private function getRecordsFiltered(QueryBuilder $filteredTotal): int
{
    try {
        return (int) $filteredTotal->getQuery()->getSingleScalarResult();
    } catch (NonUniqueResultException $e) {
        return 0;
    }
}
}
