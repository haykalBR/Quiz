<?php

namespace App\Core\Datatable\Factory;

use App\Core\Datatable\Option\RefLevelBuildOption;
use App\Core\Datatable\Option\RegistryHandler;
use App\Entity\RefLevel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DataTable
{
    private array $search;
    private array $orders;
    private array $columns;
    private array $hiddenColumn;
    private array $joins;
    private  EntityManagerInterface $manager;
    private RequestStack $request;
    private RegistryHandler $handler;

    public function __construct(RequestStack $request ,EntityManagerInterface  $manager ,RegistryHandler $handler)
   {
       $this->search = $requestQuery['search'] ?? [];
       $this->orders = $requestQuery['order'] ?? [];
       $this->columns = $requestQuery['columns'] ?? [];
       $this->hiddenColumn = $requestQuery['hiddenColumn'] ?? [];
       $this->joins = $requestQuery['join'] ?? [];
       $this->request = $request;
       $this->manager=$manager;
       $resolver = new OptionsResolver();
      // dd($resolver);
       $this->handler = $handler;
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
    public function dataTable($className): array
    {
        $request = $this->request->getCurrentRequest();
        if ($request) {
            $requestQuery = $request->query->all();

            $draw = $requestQuery['draw'] ?? '1';
            $this->queryBuilder = $this->manager->createQueryBuilder()->from($className,'t')
                ->select($this->selectColumns())
            ;
            $total = $this->manager->createQueryBuilder()->from($className,'t')->select('count(t.id)');
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
                $result['t_buttons'] =$this->handler->build('level',$result);
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

}