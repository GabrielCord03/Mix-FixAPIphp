<?php
<?php

class PlaylistService {
    private static $playlists = [];

    public function adicionarPlaylist($dados) {
        $validacao = $this->validarDadosPlaylist($dados);
        if (!$validacao['valido']) {
            return ['erros' => $validacao['erros']];
        }
        $dados['id'] = $this->gerarProximoId(self::$playlists);
        self::$playlists[] = $dados;
        return $dados;
    }

    public function buscarPlaylistPorId($id) {
        foreach (self::$playlists as $playlist) {
            if ($playlist['id'] == $id) {
                return $playlist;
            }
        }
        return null;
    }

    public function atualizarPlaylist($id, $dados) {
        $validacao = $this->validarDadosPlaylist($dados, true);
        if (!$validacao['valido']) {
            return ['erros' => $validacao['erros']];
        }
        foreach (self::$playlists as &$playlist) {
            if ($playlist['id'] == $id) {
                $playlist['nome'] = $dados['nome'];
                $playlist['descricao'] = $dados['descricao'] ?? '';
                return $playlist;
            }
        }
        return null;
    }

    public function excluirPlaylist($id) {
        foreach (self::$playlists as $i => $playlist) {
            if ($playlist['id'] == $id) {
                array_splice(self::$playlists, $i, 1);
                return true;
            }
        }
        return false;
    }

    private function gerarProximoId($arrayDeRecursos) {
        if (empty($arrayDeRecursos)) return 1;
        $ids = array_column($arrayDeRecursos, 'id');
        return max($ids) + 1;
    }

    // Validação robusta
    private function validarDadosPlaylist($dados, $atualizacao = false) {
        $erros = [];
        if (!isset($dados['nome']) || !is_string($dados['nome']) || trim($dados['nome']) === '') {
            $erros['nome'] = 'Nome é obrigatório e deve ser uma string não vazia.';
        } elseif (strlen($dados['nome']) > 50) {
            $erros['nome'] = 'Nome não pode exceder 50 caracteres.';
        }
        if (isset($dados['descricao']) && strlen($dados['descricao']) > 200) {
            $erros['descricao'] = 'Descrição não pode exceder 200 caracteres.';
        }
        return [
            'valido' => empty($erros),
            'erros' => $erros
        ];
    }
}
?>