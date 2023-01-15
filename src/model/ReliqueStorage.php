<?php

interface ReliqueStorage
{
    public function read($id);

    public function readAll();
    public function create(Relique $relique);
    public function delete($id);
    public function update($id, Relique $relique);
    
}
