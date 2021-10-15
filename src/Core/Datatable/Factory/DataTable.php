<?php

namespace App\Core\Datatable\Factory;

use App\Core\Datatable\Option\RegistryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\RequestStack;


use Doctrine\ORM\Query\Expr;

class DataTable implements DataTableInterface
{
    private EntityManagerInterface $manager;
    private RequestStack $requestStack;
    private int $filteredTotal;
    private array $search;
    private array $orders;
    private array $columns;
    private array $hiddenColumn;
    private array $joins;
    protected string $entityName;
    protected  $typeButton;

    protected QueryBuilder $queryBuilder;
    private RegistryHandler $handler;

    public function __construct(EntityManagerInterface $manager,RequestStack $requestStack,RegistryHandler $handler)
    {
        $this->manager = $manager;
        $this->requestStack = $requestStack;
        $this->queryBuilder = $this->manager->createQueryBuilder();
        $requestQuery = $requestStack->getCurrentRequest()->query->all();
        $this->search = $requestQuery['search'] ?? [];
        $this->orders = $requestQuery['order'] ?? [];
        $this->columns = $requestQuery['columns'] ?? [];
        $this->hiddenColumn = $requestQuery['hiddenColumn'] ?? [];
        $this->joins = $requestQuery['join'] ?? [];

        $this->handler = $handler;
    }
    function getTotalRecords(): int
    {
        try {
            return (int) $this->queryBuilder->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }
    function setEntity($entity_name):DataTableInterface
    {
        $this->entityName=$entity_name;
        return $this;
    }
    function setTypeButtons($type_button): DataTableInterface
    {
        $this->typeButton=$type_button;
        return $this;
    }
    function getRecordsFiltered():int
    {
        try {
            return (int) $this->queryBuilder->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }
    function setSearch(QueryBuilder $filteredTotal):QueryBuilder
    {
        $searchlist = [];
        foreach ($this->columns as $column) {
            if ($column['searchable'] === 'true') {
                $searchlist[] = $this->queryBuilder->expr()
                    ->like($column['name'], '\'%'.\trim($this->search['value']).'%\'')
                ;
            }
        }
        foreach ($this->hiddenColumn as $column) {
            $searchlist[] = $this->queryBuilder->expr()
                ->like($column['name'], '\'%'.\trim($this->search['value']).'%\'')
            ;
        }

        if (!empty($searchlist)) {
            $this->queryBuilder->andWhere(new Expr\Orx($searchlist));
            $filteredTotal->andWhere(new Expr\Orx($searchlist));
        }

        return $filteredTotal;
    }
    function setPaginationRecords(array $requestQuery): void
    {
        $start = (int) $requestQuery['start'] ?? 0;
        $length = (int) $requestQuery['length'] ?? 50;
        $this->queryBuilder->setFirstResult($start)
            ->setMaxResults($length)
        ;
    }
    function setOrderBy(): void
    {
        foreach ($this->orders as $order) {
            $this->queryBuilder->addOrderBy($this->columns[$order['column']]['name'], $order['dir']);
        }
    }
    function setJoins(QueryBuilder $filteredTotal): QueryBuilder
    {
        foreach ($this->joins as $join) {
            $this->queryBuilder->leftJoin($join['join'], $join['alias'], Expr\Join::WITH, $join['condition']);
            $filteredTotal->leftJoin($join['join'], $join['alias'], Expr\Join::WITH, $join['condition']);
        }

        return $filteredTotal;
    }
    function selectColumns(): string
    {
        $column = '';
        foreach (\array_merge($this->columns, $this->hiddenColumn) as $colums) {
            if (!isset($colums['searchable']) || (isset($colums['searchable']) && $colums['searchable'] === 'true') && !empty($colums['name']) && \mb_strpos($column, $colums['name']) === false) {
                $column .= $colums['name'].' AS '.$colums['data'].',';
            }
        }

        return empty($column) ? 't' : \rtrim($column, ',');
    }
    function dataTable(): array
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request) {
            $requestQuery = $request->query->all();

            $draw = $requestQuery['draw'] ?? '1';
            $this->queryBuilder = $this->manager->createQueryBuilder()->from($this->entityName, 't')
                ->select($this->selectColumns())
            ;
            $total = $this->manager->createQueryBuilder()->from($this->entityName, 't')->select('count(t.id)');
            $filteredTotal = $this->setJoins(clone $total);
            $filteredTotal = $this->setSearch($filteredTotal);
            $this->setOrderBy();
            $this->setPaginationRecords($requestQuery);
            $recordsTotal = $this->getTotalRecords($total);
            $recordsFiltered = $this->getRecordsFiltered($filteredTotal);
            $results = [];
            foreach ($this->queryBuilder->getQuery()->getScalarResult() as $result) {
                $result['t_buttons'] = $this->handler->build($this->typeButton, $result);
                $results[] = $result;
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
}