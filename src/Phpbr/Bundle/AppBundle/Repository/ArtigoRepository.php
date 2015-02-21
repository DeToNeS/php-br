<?php

namespace Phpbr\Bundle\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArtigoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArtigoRepository extends EntityRepository
{

    /**
     * @param null $qte
     *
     * @return array
     */
    public function listaArtigosAtivos($qte = null) {

        $query = $this->createQueryBuilder('Artigo')
            ->where('Artigo.publicado = :flagPublicado')
            ->andWhere('Artigo.aprovado = :aprovado')
            ->orderBy('Artigo.score', 'DESC')
            ->addOrderBy('Artigo.dataPublicado', 'DESC')
            ->setParameters(array(
                'flagPublicado' => true,
                'aprovado' => true
            ));

        if (is_numeric($qte)) $query->setMaxResults($qte);

        $query = $query->getQuery();

        return $query->getResult();
    }

    /**
     * @param $usuario
     * @param null $qte
     *
     * @return array
     */
    public function listaArtigosUsuario($usuario, $qte = null) {

        $query = $this->createQueryBuilder('Artigo')
            ->where('Artigo.user = :usuario')
            ->orderBy('Artigo.score', 'DESC')
            ->addOrderBy('Artigo.id', 'DESC')
            ->setParameter('usuario', $usuario);

        if (is_numeric($qte)) $query->setMaxResults($qte);

        $query = $query->getQuery();

        return $query->getResult();
    }

    /**
     * Lista todos os artigos, independentemente de seu status
     * @return array
     */
    public function listaAdminArtigos() {

        $query = $this->createQueryBuilder('Artigo')
            ->andWhere('Artigo.publicado = true')
            ->orderBy('Artigo.dataPublicado', 'ASC');

        return $query->getQuery()->getResult();
    }

}

