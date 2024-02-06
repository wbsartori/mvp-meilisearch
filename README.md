# mvp-meilisearch

### Download meilisearch 1.6.0

Acesse a documentação [Meilisearch Pages](https://www.meilisearch.com/docs/learn/getting_started/installation).

---

#### Server start


Added Documents Example

```php
    public function addDocument()
    {
        try {
            $messageDataProcessor = new DataAppender();

            $messageDataProcessor->setIndexKey('chave2');
            $documents = [
                ['id' => 1, 'title' => 'Carol', 'genres' => ['Romance, Drama']],
                ['id' => 2, 'title' => 'Wonder Woman', 'genres' => ['Action, Adventure']],
                ['id' => 3, 'title' => 'Life of Pi', 'genres' => ['Adventure, Drama']],
                ['id' => 4, 'title' => 'Mad Max: Fury Road', 'genres' => ['Adventure, Science Fiction']],
                ['id' => 5, 'title' => 'Moana', 'genres' => ['Fantasy, Action']],
                ['id' => 6, 'title' => 'Philadelphia', 'genres' => ['Drama']],
            ];
            echo $messageDataProcessor->addNewDocuments($documents);
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
```