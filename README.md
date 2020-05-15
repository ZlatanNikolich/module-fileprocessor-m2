#Magento 2 File Processor Module

Module provides queue functionality to process file tasks.

##How to use the module

Module creates queue functionality to process file tasks. 
3-d party developers able to create and register own processor for specific file tasks by adding processor as 
dependency injection to `Lava\FileProcessor\Model\ProcessorList` in di.xml as following:

```
<type name="Lava\FileProcessor\Model\ProcessorList">
        <arguments>
            <argument name="processors" xsi:type="array">
                <item name="lava_fileprocessor_examples_csv_reader" xsi:type="object">Lava\FileProcessorExamples\FileProcessor\CsvReaderProcessor</item>
            </argument>
        </arguments>
    </type>
```

After adding processor to `ProcessorList` processor will be executed automatically.
