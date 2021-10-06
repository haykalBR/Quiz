<?php
namespace App\Core\Repository;
use App\Core\Enum\DataTableEnum;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Request;

trait BaseRepositoryTrait
{


    public function dataTable(): array
    {
        $request=$this->requestStack->getCurrentRequest();
        $draw         = (int) ($request->query->all()['draw']);
        $start        = $request->query->all()['start'];
        $length       = $request->query->all()['length'];
        $search       = $request->query->all()['search'];
        $orders       = $request->query->all()['order'];
        $columns      = $request->query->all()['columns'];
        $hiddenColumn = $request->query->all('hiddenColumn');
        if (isset($columns)) {
            $column = '';
            foreach ($columns as $colums) {
                if ('true' === $colums['searchable'] and false === mb_strpos($column, $colums['name'])) {
                    $column .= $colums['name'].' AS '.$colums['data'].',';
                }
            }
        } else {
            $column = 't';
        }
        if (isset($hiddenColumn)) {
            foreach ($hiddenColumn as $colums) {
                if (false === mb_strpos($column, $colums['name'])) {
                    $column .= $colums['name'].' AS '.$colums['data'].',';
                }
            }
        }
        /**
         * Select table with Colmuns.
         */
        $qb = $this->createQueryBuilder('t')->select(rtrim($column, ','));
        /**
         * get Total Items in database.
         */
        $total = $this->createQueryBuilder('t')->select('count(t.id)');
        /**
         *  get Flitred Item.
         */
        $FilteredTotal = clone $total;
        if (isset($request->query->all()['join'])) {
            $joins = $request->query->all()['join'];
            foreach ($joins as $join) {
                $qb->leftJoin($join['join'], $join['alias'], Expr\Join::WITH, $join['condition']);
                $FilteredTotal->leftJoin($join['join'], $join['alias'], Expr\Join::WITH, $join['condition']);
            }
        }
        /*
         *  Set Start item
         */
        if (isset($start)) {
            $qb->setFirstResult((int) $start);
        }
        /*
         *  Set Length count item perpage  item
         */
        if (isset($length)) {
            $qb->setMaxResults((int) $length);
        }
        /*
         *  Set Ordred By cloumn
         */
        if (isset($orders)) {
            foreach ($orders as $order) {
                $qb->addOrderBy($columns[$order['column']]['name'], $order['dir']);
            }
        }
        /**
         *  Get List of search.
         */
        $searchlist = [];
        if (isset($columns) and isset($search) and '' !== $search['value']) {
            foreach ($columns as $column) {
                if ('true' === $column['searchable']) {
                    $searchlist[] = $qb->expr()->like('CAST('.$column['name'].' as text)', '\'%'.trim($search['value']).'%\''
                    );
                }
            }
            foreach ($hiddenColumn as $column) {
                $searchlist[] = $qb->expr()->like('CAST('.$column['name'].' as text)', '\'%'.trim($search['value']).'%\'');
            }
        }

        /*
         *  if list search not empty serach
         */
        if (!empty($searchlist)) {
            $qb->andWhere(new Expr\Andx($searchlist));
            $FilteredTotal->andWhere(new Expr\Andx($searchlist));
        }
        try {
            /**
             *  get all count itmes.
             */
            $recordsTotal = $total->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            $recordsTotal = 0;
        }
        try {
            /**
             *  get filtred  count itmes.
             */
            $recordsFiltered = $FilteredTotal->getQuery()->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            $recordsFiltered = 0;
        }
        return [
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $qb->getQuery()->getScalarResult(),
        ];
    }
}