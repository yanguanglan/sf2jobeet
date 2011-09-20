<?php
namespace Jobeet\FrontendBundle\Lucene;

use Zend\Search\Lucene as Lucene;

class MyLucene
{
	protected $index_file;
	
	public function __construct($index_file)
	{
		$this->index_file = $index_file;
		Lucene\Search\QueryParser::setDefaultEncoding('utf-8');
		Lucene\Analysis\Analyzer\Analyzer::setDefault(
			new Lucene\Analysis\Analyzer\Common\Utf8\CaseInSensitive()
		);
	}
	
	protected function getIndex()
	{
		if (file_exists($this->index_file)) return Lucene\Lucene::open($this->index_file);
		return Lucene\Lucene::create($this->index_file);
	}
	
	public function indexData($array,$encoding = 'utf-8')
	{
		$index = $this->getIndex();
		foreach ($index->find('pk:'.$array['id']) as $hit)
		{
			$index->delete($hit->id);
		}
		
		$doc = new Lucene\Document();
		$doc->addField(Lucene\Document\Field::Keyword('pk',$array['id']));
		array_shift($array);
		foreach ($array as $prop_name => $prop)
		{
			$doc->addField(Lucene\Document\Field::Text($prop_name,$prop,$encoding));
		}
		
		$index->addDocument($doc);
	}
	
	public function findData($query)
	{
		$index = $this->getIndex();
		$hits = $index->find($query);
		$idx = array();
		foreach ($hits as $hit)
		{
			$idx[] = $hit->pk;
		}
		return $idx;
	}
	
	public function removeData($id)
	{
		$index = $this->getIndex();
		foreach ($index->find('pk:'.$id) as $hit)
		{
			$index->delete($hit->id);
		}
	}
}