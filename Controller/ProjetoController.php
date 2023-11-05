<?php


class ProjetoCliente
{

    public function TotalClientes()
    {
        include './Conexao.php';

        $sql = "SELECT count(idCliente) 
                FROM tbcliente";
        
        $query = mysqli_query($conexao, $sql);
        $busca = mysqli_fetch_column($query)[0];

        return $busca;
    }

    public function TotalVendas()
    {
        include './Conexao.php';

        $sql = "SELECT count(idProjeto) 
                FROM tbprojetos";
        
        $query = mysqli_query($conexao, $sql);
        $busca = mysqli_fetch_column($query);

        return $busca;
    }

    public function NotaProjetos()
    {
        include './Conexao.php';

        $sql = "SELECT AVG(notaProjeto) 
                FROM tbprojetos";
        
        $query = mysqli_query($conexao, $sql);
        $busca = mysqli_fetch_column($query)[0];

        return $busca;
    }

    public function Mes()
    {

        include './Conexao.php';

        
        //$dado = mysqli_fetch_assoc($busca);

        $busca = [];
        for($i = 0; $i < 12; $i++)
        {
            $mes = $i + 1;
            $sql = "SELECT COUNT(idProjeto) 
                    FROM tbprojetos 
                    WHERE MONTH(dataProjeto) = ".$mes;

            $query = mysqli_query($conexao, $sql);
            $busca[] = mysqli_fetch_array($query)[0];
        }

        return $busca;
    }


    public function ClientesPorProjeto()
    {

        include './Conexao.php';

            $sql = "SELECT c.nomeCliente, count(p.idProjeto) from tbprojetos p
                    right join tbcliente c on c.idCliente=p.idCliente
                    group by c.nomeCliente
                    LIMIT 7";
            $query = mysqli_query($conexao, $sql);
            
            $nomes = [];
            $values = [];

        while($row = $query->fetch_row()) {
            $nomes[] = $row[0];
            $values[] = $row[1];
        }


        return array($nomes, $values);
     
    }

    public function ProjetosPorCategoria()
    {
        include './Conexao.php';

            $sql = "SELECT c.nomeCategoria, count(p.idProjeto) from tbprojetos p
                        right join tbcategorias c on c.idCategoria=p.idCategoria
                        group by c.nomeCategoria
                        LIMIT 5";
            $query = mysqli_query($conexao, $sql);
            
            $nomes = [];
            $values = [];

        while($row = $query->fetch_row()) {
            $nomes[] = $row[0];
            $values[] = $row[1];
        }


        return array($nomes, $values);
    }


    public function ClientesLucrativos()
    {
        include './Conexao.php';

            $sql = "SELECT c.nomeCliente, sum(p.precoProjeto) from tbprojetos p
                    right join tbcliente c on c.idCliente=p.idCliente
                    group by c.nomeCliente
                    order by sum(p.precoProjeto) DESC
                    LIMIT 5";

            $query = mysqli_query($conexao, $sql);
            
            $nomes = [];
            $values = [];

        while($row = $query->fetch_row()) {
            $nomes[] = $row[0];
            $values[] = $row[1];
        }


        return array($nomes, $values);

        
    }
}
