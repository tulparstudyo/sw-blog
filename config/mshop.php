<?php

return [
    'post' =>[
        'manager' => array(
            'lists' => array(
                'type' => array(
                    'standard' => array(
                        'delete' => array(
                            'ansi' => '
                                DELETE FROM "mshop_post_list_type"
                                WHERE :cond AND siteid = ?
                            '
                        ),
                        'insert' => array(
                            'ansi' => '
                                INSERT INTO "mshop_post_list_type" ( :names
                                    "code", "domain", "label", "pos", "status",
                                    "mtime", "editor", "siteid", "ctime"
                                ) VALUES ( :values
                                    ?, ?, ?, ?, ?, ?, ?, ?, ?
                                )
                            '
                        ),
                        'update' => array(
                            'ansi' => '
                                UPDATE "mshop_post_list_type"
                                SET :names
                                    "code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
                                    "status" = ?, "mtime" = ?, "editor" = ?
                                WHERE "siteid" = ? AND "id" = ?
                            '
                        ),
                        'search' => array(
                            'ansi' => '
                                SELECT :columns
                                    mprolity."id" AS "post.lists.type.id", mprolity."siteid" AS "post.lists.type.siteid",
                                    mprolity."code" AS "post.lists.type.code", mprolity."domain" AS "post.lists.type.domain",
                                    mprolity."label" AS "post.lists.type.label", mprolity."status" AS "post.lists.type.status",
                                    mprolity."mtime" AS "post.lists.type.mtime", mprolity."editor" AS "post.lists.type.editor",
                                    mprolity."ctime" AS "post.lists.type.ctime", mprolity."pos" AS "post.lists.type.position"
                                FROM "mshop_post_list_type" AS mprolity
                                :joins
                                WHERE :cond
                                ORDER BY :order
                                OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                            ',
                            'mysql' => '
                                SELECT :columns
                                    mprolity."id" AS "post.lists.type.id", mprolity."siteid" AS "post.lists.type.siteid",
                                    mprolity."code" AS "post.lists.type.code", mprolity."domain" AS "post.lists.type.domain",
                                    mprolity."label" AS "post.lists.type.label", mprolity."status" AS "post.lists.type.status",
                                    mprolity."mtime" AS "post.lists.type.mtime", mprolity."editor" AS "post.lists.type.editor",
                                    mprolity."ctime" AS "post.lists.type.ctime", mprolity."pos" AS "post.lists.type.position"
                                FROM "mshop_post_list_type" AS mprolity
                                :joins
                                WHERE :cond
                                ORDER BY :order
                                LIMIT :size OFFSET :start
                            '
                        ),
                        'count' => array(
                            'ansi' => '
                                SELECT COUNT(*) AS "count"
                                FROM (
                                    SELECT mprolity."id"
                                    FROM "mshop_post_list_type" AS mprolity
                                    :joins
                                    WHERE :cond
                                    ORDER BY mprolity."id"
                                    OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
                                ) AS list
                            ',
                            'mysql' => '
                                SELECT COUNT(*) AS "count"
                                FROM (
                                    SELECT mprolity."id"
                                    FROM "mshop_post_list_type" AS mprolity
                                    :joins
                                    WHERE :cond
                                    ORDER BY mprolity."id"
                                    LIMIT 10000 OFFSET 0
                                ) AS list
                            '
                        ),
                        'newid' => array(
                            'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
                            'mysql' => 'SELECT LAST_INSERT_ID()',
                            'oracle' => 'SELECT mshop_post_list_type_seq.CURRVAL FROM DUAL',
                            'pgsql' => 'SELECT lastval()',
                            'sqlite' => 'SELECT last_insert_rowid()',
                            'sqlsrv' => 'SELECT @@IDENTITY',
                            'sqlanywhere' => 'SELECT @@IDENTITY',
                        ),
                    ),
                ),
                'standard' => array(
                    'aggregate' => array(
                        'ansi' => '
                            SELECT "key", COUNT("id") AS "count"
                            FROM (
                                SELECT :key AS "key", mproli."id" AS "id"
                                FROM "mshop_post_list" AS mproli
                                :joins
                                WHERE :cond
                                GROUP BY :key, mproli."id"
                                ORDER BY :order
                                OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                            ) AS list
                            GROUP BY "key"
                        ',
                        'mysql' => '
                            SELECT "key", COUNT("id") AS "count"
                            FROM (
                                SELECT :key AS "key", mproli."id" AS "id"
                                FROM "mshop_post_list" AS mproli
                                :joins
                                WHERE :cond
                                GROUP BY :key, mproli."id"
                                ORDER BY :order
                                LIMIT :size OFFSET :start
                            ) AS list
                            GROUP BY "key"
                        '
                    ),
                    'delete' => array(
                        'ansi' => '
                            DELETE FROM "mshop_post_list"
                            WHERE :cond AND siteid = ?
                        '
                    ),
                    'insert' => array(
                        'ansi' => '
                            INSERT INTO "mshop_post_list" ( :names
                                "parentid", "key", "type", "domain", "refid", "start", "end",
                                "config", "pos", "status", "mtime", "editor", "siteid", "ctime"
                            ) VALUES ( :values
                                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                            )
                        '
                    ),
                    'update' => array(
                        'ansi' => '
                            UPDATE "mshop_post_list"
                            SET :names
                                "parentid" = ?, "key" = ?, "type" = ?, "domain" = ?, "refid" = ?, "start" = ?,
                                "end" = ?, "config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
                            WHERE "siteid" = ? AND "id" = ?
                        '
                    ),
                    'search' => array(
                        'ansi' => '
                            SELECT :columns
                                mproli."id" AS "post.lists.id", mproli."parentid" AS "post.lists.parentid",
                                mproli."siteid" AS "post.lists.siteid", mproli."type" AS "post.lists.type",
                                mproli."domain" AS "post.lists.domain", mproli."refid" AS "post.lists.refid",
                                mproli."start" AS "post.lists.datestart", mproli."end" AS "post.lists.dateend",
                                mproli."config" AS "post.lists.config", mproli."pos" AS "post.lists.position",
                                mproli."status" AS "post.lists.status", mproli."mtime" AS "post.lists.mtime",
                                mproli."editor" AS "post.lists.editor", mproli."ctime" AS "post.lists.ctime"
                            FROM "mshop_post_list" AS mproli
                            :joins
                            WHERE :cond
                            ORDER BY :order
                            OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                        ',
                        'mysql' => '
                            SELECT :columns
                                mproli."id" AS "post.lists.id", mproli."parentid" AS "post.lists.parentid",
                                mproli."siteid" AS "post.lists.siteid", mproli."type" AS "post.lists.type",
                                mproli."domain" AS "post.lists.domain", mproli."refid" AS "post.lists.refid",
                                mproli."start" AS "post.lists.datestart", mproli."end" AS "post.lists.dateend",
                                mproli."config" AS "post.lists.config", mproli."pos" AS "post.lists.position",
                                mproli."status" AS "post.lists.status", mproli."mtime" AS "post.lists.mtime",
                                mproli."editor" AS "post.lists.editor", mproli."ctime" AS "post.lists.ctime"
                            FROM "mshop_post_list" AS mproli
                            :joins
                            WHERE :cond
                            ORDER BY :order
                            LIMIT :size OFFSET :start
                        '
                    ),
                    'count' => array(
                        'ansi' => '
                            SELECT COUNT(*) AS "count"
                            FROM (
                                SELECT mproli."id"
                                FROM "mshop_post_list" AS mproli
                                :joins
                                WHERE :cond
                                ORDER BY mproli."id"
                                OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
                            ) AS list
                        ',
                        'mysql' => '
                            SELECT COUNT(*) AS "count"
                            FROM (
                                SELECT mproli."id"
                                FROM "mshop_post_list" AS mproli
                                :joins
                                WHERE :cond
                                ORDER BY mproli."id"
                                LIMIT 10000 OFFSET 0
                            ) AS list
                        '
                    ),
                    'newid' => array(
                        'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
                        'mysql' => 'SELECT LAST_INSERT_ID()',
                        'oracle' => 'SELECT mshop_post_list_seq.CURRVAL FROM DUAL',
                        'pgsql' => 'SELECT lastval()',
                        'sqlite' => 'SELECT last_insert_rowid()',
                        'sqlsrv' => 'SELECT @@IDENTITY',
                        'sqlanywhere' => 'SELECT @@IDENTITY',
                    ),
                ),
            ),
            'property' => array(
                'type' => array(
                    'standard' => array(
                        'delete' => array(
                            'ansi' => '
                                DELETE FROM "mshop_post_property_type"
                                WHERE :cond AND siteid = ?
                            '
                        ),
                        'insert' => array(
                            'ansi' => '
                                INSERT INTO "mshop_post_property_type" ( :names
                                    "code", "domain", "label", "pos", "status",
                                    "mtime", "editor", "siteid", "ctime"
                                ) VALUES ( :values
                                    ?, ?, ?, ?, ?, ?, ?, ?, ?
                                )
                            '
                        ),
                        'update' => array(
                            'ansi' => '
                                UPDATE "mshop_post_property_type"
                                SET :names
                                    "code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
                                    "status" = ?, "mtime" = ?, "editor" = ?
                                WHERE "siteid" = ? AND "id" = ?
                            '
                        ),
                        'search' => array(
                            'ansi' => '
                                SELECT :columns
                                    mproprty."id" AS "post.property.type.id", mproprty."siteid" AS "post.property.type.siteid",
                                    mproprty."code" AS "post.property.type.code", mproprty."domain" AS "post.property.type.domain",
                                    mproprty."label" AS "post.property.type.label", mproprty."status" AS "post.property.type.status",
                                    mproprty."mtime" AS "post.property.type.mtime", mproprty."editor" AS "post.property.type.editor",
                                    mproprty."ctime" AS "post.property.type.ctime", mproprty."pos" AS "post.property.type.position"
                                FROM "mshop_post_property_type" mproprty
                                :joins
                                WHERE :cond
                                ORDER BY :order
                                OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                            ',
                            'mysql' => '
                                SELECT :columns
                                    mproprty."id" AS "post.property.type.id", mproprty."siteid" AS "post.property.type.siteid",
                                    mproprty."code" AS "post.property.type.code", mproprty."domain" AS "post.property.type.domain",
                                    mproprty."label" AS "post.property.type.label", mproprty."status" AS "post.property.type.status",
                                    mproprty."mtime" AS "post.property.type.mtime", mproprty."editor" AS "post.property.type.editor",
                                    mproprty."ctime" AS "post.property.type.ctime", mproprty."pos" AS "post.property.type.position"
                                FROM "mshop_post_property_type" mproprty
                                :joins
                                WHERE :cond
                                ORDER BY :order
                                LIMIT :size OFFSET :start
                            '
                        ),
                        'count' => array(
                            'ansi' => '
                                SELECT COUNT(*) AS "count"
                                FROM (
                                    SELECT mproprty."id"
                                    FROM "mshop_post_property_type" mproprty
                                    :joins
                                    WHERE :cond
                                    ORDER BY mproprty."id"
                                    OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
                                ) AS list
                            ',
                            'mysql' => '
                                SELECT COUNT(*) AS "count"
                                FROM (
                                    SELECT mproprty."id"
                                    FROM "mshop_post_property_type" mproprty
                                    :joins
                                    WHERE :cond
                                    ORDER BY mproprty."id"
                                    LIMIT 10000 OFFSET 0
                                ) AS list
                            '
                        ),
                        'newid' => array(
                            'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
                            'mysql' => 'SELECT LAST_INSERT_ID()',
                            'oracle' => 'SELECT mshop_post_property_type_seq.CURRVAL FROM DUAL',
                            'pgsql' => 'SELECT lastval()',
                            'sqlite' => 'SELECT last_insert_rowid()',
                            'sqlsrv' => 'SELECT @@IDENTITY',
                            'sqlanywhere' => 'SELECT @@IDENTITY',
                        ),
                    ),
                ),
                'standard' => array(
                    'delete' => array(
                        'ansi' => '
                            DELETE FROM "mshop_post_property"
                            WHERE :cond AND siteid = ?
                        '
                    ),
                    'insert' => array(
                        'ansi' => '
                            INSERT INTO "mshop_post_property" ( :names
                                "parentid", "key", "type", "langid", "value",
                                "mtime", "editor", "siteid", "ctime"
                            ) VALUES ( :values
                                ?, ?, ?, ?, ?, ?, ?, ?, ?
                            )
                        '
                    ),
                    'update' => array(
                        'ansi' => '
                            UPDATE "mshop_post_property"
                            SET :names
                                "parentid" = ?, "key" = ?, "type" = ?, "langid" = ?,
                                "value" = ?, "mtime" = ?, "editor" = ?
                            WHERE "siteid" = ? AND "id" = ?
                        '
                    ),
                    'search' => array(
                        'ansi' => '
                            SELECT :columns
                                mpropr."id" AS "post.property.id", mpropr."parentid" AS "post.property.parentid",
                                mpropr."siteid" AS "post.property.siteid", mpropr."type" AS "post.property.type",
                                mpropr."langid" AS "post.property.languageid", mpropr."value" AS "post.property.value",
                                mpropr."mtime" AS "post.property.mtime", mpropr."editor" AS "post.property.editor",
                                mpropr."ctime" AS "post.property.ctime"
                            FROM "mshop_post_property" AS mpropr
                            :joins
                            WHERE :cond
                            ORDER BY :order
                            OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                        ',
                        'mysql' => '
                            SELECT :columns
                                mpropr."id" AS "post.property.id", mpropr."parentid" AS "post.property.parentid",
                                mpropr."siteid" AS "post.property.siteid", mpropr."type" AS "post.property.type",
                                mpropr."langid" AS "post.property.languageid", mpropr."value" AS "post.property.value",
                                mpropr."mtime" AS "post.property.mtime", mpropr."editor" AS "post.property.editor",
                                mpropr."ctime" AS "post.property.ctime"
                            FROM "mshop_post_property" AS mpropr
                            :joins
                            WHERE :cond
                            ORDER BY :order
                            LIMIT :size OFFSET :start
                        '
                    ),
                    'count' => array(
                        'ansi' => '
                            SELECT COUNT(*) AS "count"
                            FROM (
                                SELECT mpropr."id"
                                FROM "mshop_post_property" AS mpropr
                                :joins
                                WHERE :cond
                                ORDER BY mpropr."id"
                                OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
                            ) AS list
                        ',
                        'mysql' => '
                            SELECT COUNT(*) AS "count"
                            FROM (
                                SELECT mpropr."id"
                                FROM "mshop_post_property" AS mpropr
                                :joins
                                WHERE :cond
                                ORDER BY mpropr."id"
                                LIMIT 10000 OFFSET 0
                            ) AS list
                        '
                    ),
                    'newid' => array(
                        'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
                        'mysql' => 'SELECT LAST_INSERT_ID()',
                        'oracle' => 'SELECT mshop_post_property_seq.CURRVAL FROM DUAL',
                        'pgsql' => 'SELECT lastval()',
                        'sqlite' => 'SELECT last_insert_rowid()',
                        'sqlsrv' => 'SELECT @@IDENTITY',
                        'sqlanywhere' => 'SELECT @@IDENTITY',
                    ),
                ),
            ),
            'type' => array(
                'standard' => array(
                    'delete' => array(
                        'ansi' => '
                            DELETE FROM "mshop_post_type"
                            WHERE :cond AND siteid = ?
                        '
                    ),
                    'insert' => array(
                        'ansi' => '
                            INSERT INTO "mshop_post_type" ( :names
                                "code", "domain", "label", "pos", "status",
                                "mtime", "editor", "siteid", "ctime"
                            ) VALUES ( :values
                                ?, ?, ?, ?, ?, ?, ?, ?, ?
                            )
                        '
                    ),
                    'update' => array(
                        'ansi' => '
                            UPDATE "mshop_post_type"
                            SET :names
                                "code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
                                "status" = ?, "mtime" = ?, "editor" = ?
                            WHERE "siteid" = ? AND "id" = ?
                        '
                    ),
                    'search' => array(
                        'ansi' => '
                            SELECT :columns
                                mproty."id" AS "post.type.id", mproty."siteid" AS "post.type.siteid",
                                mproty."code" AS "post.type.code", mproty."domain" AS "post.type.domain",
                                mproty."label" AS "post.type.label", mproty."status" AS "post.type.status",
                                mproty."mtime" AS "post.type.mtime", mproty."editor" AS "post.type.editor",
                                mproty."ctime" AS "post.type.ctime", mproty."pos" AS "post.type.position"
                            FROM "mshop_post_type" AS mproty
                            :joins
                            WHERE :cond
                            ORDER BY :order
                            OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                        ',
                        'mysql' => '
                            SELECT :columns
                                mproty."id" AS "post.type.id", mproty."siteid" AS "post.type.siteid",
                                mproty."code" AS "post.type.code", mproty."domain" AS "post.type.domain",
                                mproty."label" AS "post.type.label", mproty."status" AS "post.type.status",
                                mproty."mtime" AS "post.type.mtime", mproty."editor" AS "post.type.editor",
                                mproty."ctime" AS "post.type.ctime", mproty."pos" AS "post.type.position"
                            FROM "mshop_post_type" AS mproty
                            :joins
                            WHERE :cond
                            ORDER BY :order
                            LIMIT :size OFFSET :start
                        '
                    ),
                    'count' => array(
                        'ansi' => '
                            SELECT COUNT(*) AS "count"
                            FROM (
                                SELECT mproty."id"
                                FROM "mshop_post_type" AS mproty
                                :joins
                                WHERE :cond
                                ORDER BY mproty."id"
                                OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
                            ) AS list
                        ',
                        'mysql' => '
                            SELECT COUNT(*) AS "count"
                            FROM (
                                SELECT mproty."id"
                                FROM "mshop_post_type" AS mproty
                                :joins
                                WHERE :cond
                                ORDER BY mproty."id"
                                LIMIT 10000 OFFSET 0
                            ) AS list
                        '
                    ),
                    'newid' => array(
                        'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
                        'mysql' => 'SELECT LAST_INSERT_ID()',
                        'oracle' => 'SELECT mshop_post_type_seq.CURRVAL FROM DUAL',
                        'pgsql' => 'SELECT lastval()',
                        'sqlite' => 'SELECT last_insert_rowid()',
                        'sqlsrv' => 'SELECT @@IDENTITY',
                        'sqlanywhere' => 'SELECT @@IDENTITY',
                    ),
                ),
            ),
            'standard' => array(
                'delete' => array(
                    'ansi' => '
                        DELETE FROM "mshop_post"
                        WHERE :cond AND siteid = ?
                    '
                ),
                'insert' => array(
                    'ansi' => '
                        INSERT INTO "mshop_post" ( :names
                            "type", "code", "dataset", "label", "url", "status", "scale", "start", "end",
                            "config", "target", "editor", "mtime", "ctime", "siteid"
                        ) VALUES ( :values
                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                        )
                    '
                ),
                'update' => array(
                    'ansi' => '
                        UPDATE "mshop_post"
                        SET :names
                            "type" = ?, "code" = ?, "dataset" = ?, "label" = ?, "url" = ?, "status" = ?, "scale" = ?,
                            "start" = ?, "end" = ?, "config" = ?, "target" = ?, "editor" = ?, "mtime" = ?, "ctime" = ?
                        WHERE "siteid" = ? AND "id" = ?
                    '
                ),
                'rate' => array(
                    'ansi' => '
                        UPDATE "mshop_post"
                        SET "rating" = ?, "ratings" = ?
                        WHERE "siteid" = ? AND "id" = ?
                    '
                ),
                'search' => array(
                    'ansi' => '
                        SELECT :columns
                            mpro."id" AS "post.id", mpro."siteid" AS "post.siteid",
                            mpro."type" AS "post.type", mpro."code" AS "post.code",
                            mpro."label" AS "post.label", mpro."url" AS "post.url",
                            mpro."start" AS "post.datestart", mpro."end" AS "post.dateend",
                            mpro."status" AS "post.status", mpro."ctime" AS "post.ctime",
                            mpro."mtime" AS "post.mtime", mpro."editor" AS "post.editor",
                            mpro."target" AS "post.target", mpro."dataset" AS "post.dataset",
                            mpro."scale" AS "post.scale", mpro."config" AS "post.config",
                            mpro."rating" AS "post.rating", mpro."ratings" AS "post.ratings"
                        FROM "mshop_post" AS mpro
                        :joins
                        WHERE :cond
                        GROUP BY :columns :group
                            mpro."id", mpro."siteid", mpro."type", mpro."code", mpro."label", mpro."url",
                            mpro."target", mpro."dataset", mpro."scale", mpro."config", mpro."start", mpro."end",
                            mpro."status", mpro."ctime", mpro."mtime", mpro."editor", mpro."rating", mpro."ratings"
                        ORDER BY :order
                        OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                    ',
                    'mysql' => '
                        SELECT :columns
                            mpro."id" AS "post.id", mpro."siteid" AS "post.siteid",
                            mpro."type" AS "post.type", mpro."code" AS "post.code",
                            mpro."label" AS "post.label", mpro."url" AS "post.url",
                            mpro."start" AS "post.datestart", mpro."end" AS "post.dateend",
                            mpro."status" AS "post.status", mpro."ctime" AS "post.ctime",
                            mpro."mtime" AS "post.mtime", mpro."editor" AS "post.editor",
                            mpro."target" AS "post.target", mpro."dataset" AS "post.dataset",
                            mpro."scale" AS "post.scale", mpro."config" AS "post.config",
                            mpro."rating" AS "post.rating", mpro."ratings" AS "post.ratings"
                        FROM "mshop_post" AS mpro
                        :joins
                        WHERE :cond
                        GROUP BY :group mpro."id"
                        ORDER BY :order
                        LIMIT :size OFFSET :start
                    '
                ),
                'count' => array(
                    'ansi' => '
                        SELECT COUNT(*) AS "count"
                        FROM (
                            SELECT mpro."id"
                            FROM "mshop_post" AS mpro
                            :joins
                            WHERE :cond
                            GROUP BY mpro."id"
                            ORDER BY mpro."id"
                            OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
                        ) AS list
                    ',
                    'mysql' => '
                        SELECT COUNT(*) AS "count"
                        FROM (
                            SELECT mpro."id"
                            FROM "mshop_post" AS mpro
                            :joins
                            WHERE :cond
                            GROUP BY mpro."id"
                            ORDER BY mpro."id"
                            LIMIT 10000 OFFSET 0
                        ) AS list
                    '
                ),
                'newid' => array(
                    'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
                    'mysql' => 'SELECT LAST_INSERT_ID()',
                    'oracle' => 'SELECT mshop_post_seq.CURRVAL FROM DUAL',
                    'pgsql' => 'SELECT lastval()',
                    'sqlite' => 'SELECT last_insert_rowid()',
                    'sqlsrv' => 'SELECT @@IDENTITY',
                    'sqlanywhere' => 'SELECT @@IDENTITY',
                ),
            ),
        ),

    ]
];
