<?php

return [
    'swpost' =>[
        'manager' => array(
            'lists' => array(
                'type' => array(
                    'standard' => array(
                        'delete' => array(
                            'ansi' => '
                                DELETE FROM "sw_post_list_type"
                                WHERE :cond AND siteid = ?
                            '
                        ),
                        'insert' => array(
                            'ansi' => '
                                INSERT INTO "sw_post_list_type" ( :names
                                    "code", "domain", "label", "pos", "status",
                                    "mtime", "editor", "siteid", "ctime"
                                ) VALUES ( :values
                                    ?, ?, ?, ?, ?, ?, ?, ?, ?
                                )
                            '
                        ),
                        'update' => array(
                            'ansi' => '
                                UPDATE "sw_post_list_type"
                                SET :names
                                    "code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
                                    "status" = ?, "mtime" = ?, "editor" = ?
                                WHERE "siteid" = ? AND "id" = ?
                            '
                        ),
                        'search' => array(
                            'ansi' => '
                                SELECT :columns
                                    mprolity."id" AS "swpost.lists.type.id", mprolity."siteid" AS "swpost.lists.type.siteid",
                                    mprolity."code" AS "swpost.lists.type.code", mprolity."domain" AS "swpost.lists.type.domain",
                                    mprolity."label" AS "swpost.lists.type.label", mprolity."status" AS "swpost.lists.type.status",
                                    mprolity."mtime" AS "swpost.lists.type.mtime", mprolity."editor" AS "swpost.lists.type.editor",
                                    mprolity."ctime" AS "swpost.lists.type.ctime", mprolity."pos" AS "swpost.lists.type.position"
                                FROM "sw_post_list_type" AS mprolity
                                :joins
                                WHERE :cond
                                ORDER BY :order
                                OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                            ',
                            'mysql' => '
                                SELECT :columns
                                    mprolity."id" AS "swpost.lists.type.id", mprolity."siteid" AS "swpost.lists.type.siteid",
                                    mprolity."code" AS "swpost.lists.type.code", mprolity."domain" AS "swpost.lists.type.domain",
                                    mprolity."label" AS "swpost.lists.type.label", mprolity."status" AS "swpost.lists.type.status",
                                    mprolity."mtime" AS "swpost.lists.type.mtime", mprolity."editor" AS "swpost.lists.type.editor",
                                    mprolity."ctime" AS "swpost.lists.type.ctime", mprolity."pos" AS "swpost.lists.type.position"
                                FROM "sw_post_list_type" AS mprolity
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
                                    FROM "sw_post_list_type" AS mprolity
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
                                    FROM "sw_post_list_type" AS mprolity
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
                            'oracle' => 'SELECT sw_post_list_type_seq.CURRVAL FROM DUAL',
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
                                FROM "sw_post_list" AS mproli
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
                                FROM "sw_post_list" AS mproli
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
                            DELETE FROM "sw_post_list"
                            WHERE :cond AND siteid = ?
                        '
                    ),
                    'insert' => array(
                        'ansi' => '
                            INSERT INTO "sw_post_list" ( :names
                                "parentid", "key", "type", "domain", "refid", "start", "end",
                                "config", "pos", "status", "mtime", "editor", "siteid", "ctime"
                            ) VALUES ( :values
                                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                            )
                        '
                    ),
                    'update' => array(
                        'ansi' => '
                            UPDATE "sw_post_list"
                            SET :names
                                "parentid" = ?, "key" = ?, "type" = ?, "domain" = ?, "refid" = ?, "start" = ?,
                                "end" = ?, "config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
                            WHERE "siteid" = ? AND "id" = ?
                        '
                    ),
                    'search' => array(
                        'ansi' => '
                            SELECT :columns
                                mproli."id" AS "swpost.lists.id", mproli."parentid" AS "swpost.lists.parentid",
                                mproli."siteid" AS "swpost.lists.siteid", mproli."type" AS "swpost.lists.type",
                                mproli."domain" AS "swpost.lists.domain", mproli."refid" AS "swpost.lists.refid",
                                mproli."start" AS "swpost.lists.datestart", mproli."end" AS "swpost.lists.dateend",
                                mproli."config" AS "swpost.lists.config", mproli."pos" AS "swpost.lists.position",
                                mproli."status" AS "swpost.lists.status", mproli."mtime" AS "swpost.lists.mtime",
                                mproli."editor" AS "swpost.lists.editor", mproli."ctime" AS "swpost.lists.ctime"
                            FROM "sw_post_list" AS mproli
                            :joins
                            WHERE :cond
                            ORDER BY :order
                            OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                        ',
                        'mysql' => '
                            SELECT :columns
                                mproli."id" AS "swpost.lists.id", mproli."parentid" AS "swpost.lists.parentid",
                                mproli."siteid" AS "swpost.lists.siteid", mproli."type" AS "swpost.lists.type",
                                mproli."domain" AS "swpost.lists.domain", mproli."refid" AS "swpost.lists.refid",
                                mproli."start" AS "swpost.lists.datestart", mproli."end" AS "swpost.lists.dateend",
                                mproli."config" AS "swpost.lists.config", mproli."pos" AS "swpost.lists.position",
                                mproli."status" AS "swpost.lists.status", mproli."mtime" AS "swpost.lists.mtime",
                                mproli."editor" AS "swpost.lists.editor", mproli."ctime" AS "swpost.lists.ctime"
                            FROM "sw_post_list" AS mproli
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
                                FROM "sw_post_list" AS mproli
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
                                FROM "sw_post_list" AS mproli
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
                        'oracle' => 'SELECT sw_post_list_seq.CURRVAL FROM DUAL',
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
                                DELETE FROM "sw_post_property_type"
                                WHERE :cond AND siteid = ?
                            '
                        ),
                        'insert' => array(
                            'ansi' => '
                                INSERT INTO "sw_post_property_type" ( :names
                                    "code", "domain", "label", "pos", "status",
                                    "mtime", "editor", "siteid", "ctime"
                                ) VALUES ( :values
                                    ?, ?, ?, ?, ?, ?, ?, ?, ?
                                )
                            '
                        ),
                        'update' => array(
                            'ansi' => '
                                UPDATE "sw_post_property_type"
                                SET :names
                                    "code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
                                    "status" = ?, "mtime" = ?, "editor" = ?
                                WHERE "siteid" = ? AND "id" = ?
                            '
                        ),
                        'search' => array(
                            'ansi' => '
                                SELECT :columns
                                    mproprty."id" AS "swpost.property.type.id", mproprty."siteid" AS "swpost.property.type.siteid",
                                    mproprty."code" AS "swpost.property.type.code", mproprty."domain" AS "swpost.property.type.domain",
                                    mproprty."label" AS "swpost.property.type.label", mproprty."status" AS "swpost.property.type.status",
                                    mproprty."mtime" AS "swpost.property.type.mtime", mproprty."editor" AS "swpost.property.type.editor",
                                    mproprty."ctime" AS "swpost.property.type.ctime", mproprty."pos" AS "swpost.property.type.position"
                                FROM "sw_post_property_type" mproprty
                                :joins
                                WHERE :cond
                                ORDER BY :order
                                OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                            ',
                            'mysql' => '
                                SELECT :columns
                                    mproprty."id" AS "swpost.property.type.id", mproprty."siteid" AS "swpost.property.type.siteid",
                                    mproprty."code" AS "swpost.property.type.code", mproprty."domain" AS "swpost.property.type.domain",
                                    mproprty."label" AS "swpost.property.type.label", mproprty."status" AS "swpost.property.type.status",
                                    mproprty."mtime" AS "swpost.property.type.mtime", mproprty."editor" AS "swpost.property.type.editor",
                                    mproprty."ctime" AS "swpost.property.type.ctime", mproprty."pos" AS "swpost.property.type.position"
                                FROM "sw_post_property_type" mproprty
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
                                    FROM "sw_post_property_type" mproprty
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
                                    FROM "sw_post_property_type" mproprty
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
                            'oracle' => 'SELECT sw_post_property_type_seq.CURRVAL FROM DUAL',
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
                            DELETE FROM "sw_post_property"
                            WHERE :cond AND siteid = ?
                        '
                    ),
                    'insert' => array(
                        'ansi' => '
                            INSERT INTO "sw_post_property" ( :names
                                "parentid", "key", "type", "langid", "value",
                                "mtime", "editor", "siteid", "ctime"
                            ) VALUES ( :values
                                ?, ?, ?, ?, ?, ?, ?, ?, ?
                            )
                        '
                    ),
                    'update' => array(
                        'ansi' => '
                            UPDATE "sw_post_property"
                            SET :names
                                "parentid" = ?, "key" = ?, "type" = ?, "langid" = ?,
                                "value" = ?, "mtime" = ?, "editor" = ?
                            WHERE "siteid" = ? AND "id" = ?
                        '
                    ),
                    'search' => array(
                        'ansi' => '
                            SELECT :columns
                                mpropr."id" AS "swpost.property.id", mpropr."parentid" AS "swpost.property.parentid",
                                mpropr."siteid" AS "swpost.property.siteid", mpropr."type" AS "swpost.property.type",
                                mpropr."langid" AS "swpost.property.languageid", mpropr."value" AS "swpost.property.value",
                                mpropr."mtime" AS "swpost.property.mtime", mpropr."editor" AS "swpost.property.editor",
                                mpropr."ctime" AS "swpost.property.ctime"
                            FROM "sw_post_property" AS mpropr
                            :joins
                            WHERE :cond
                            ORDER BY :order
                            OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                        ',
                        'mysql' => '
                            SELECT :columns
                                mpropr."id" AS "swpost.property.id", mpropr."parentid" AS "swpost.property.parentid",
                                mpropr."siteid" AS "swpost.property.siteid", mpropr."type" AS "swpost.property.type",
                                mpropr."langid" AS "swpost.property.languageid", mpropr."value" AS "swpost.property.value",
                                mpropr."mtime" AS "swpost.property.mtime", mpropr."editor" AS "swpost.property.editor",
                                mpropr."ctime" AS "swpost.property.ctime"
                            FROM "sw_post_property" AS mpropr
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
                                FROM "sw_post_property" AS mpropr
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
                                FROM "sw_post_property" AS mpropr
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
                        'oracle' => 'SELECT sw_post_property_seq.CURRVAL FROM DUAL',
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
                            DELETE FROM "sw_post_type"
                            WHERE :cond AND siteid = ?
                        '
                    ),
                    'insert' => array(
                        'ansi' => '
                            INSERT INTO "sw_post_type" ( :names
                                "code", "domain", "label", "pos", "status",
                                "mtime", "editor", "siteid", "ctime"
                            ) VALUES ( :values
                                ?, ?, ?, ?, ?, ?, ?, ?, ?
                            )
                        '
                    ),
                    'update' => array(
                        'ansi' => '
                            UPDATE "sw_post_type"
                            SET :names
                                "code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
                                "status" = ?, "mtime" = ?, "editor" = ?
                            WHERE "siteid" = ? AND "id" = ?
                        '
                    ),
                    'search' => array(
                        'ansi' => '
                            SELECT :columns
                                mproty."id" AS "swpost.type.id", mproty."siteid" AS "swpost.type.siteid",
                                mproty."code" AS "swpost.type.code", mproty."domain" AS "swpost.type.domain",
                                mproty."label" AS "swpost.type.label", mproty."status" AS "swpost.type.status",
                                mproty."mtime" AS "swpost.type.mtime", mproty."editor" AS "swpost.type.editor",
                                mproty."ctime" AS "swpost.type.ctime", mproty."pos" AS "swpost.type.position"
                            FROM "sw_post_type" AS mproty
                            :joins
                            WHERE :cond
                            ORDER BY :order
                            OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
                        ',
                        'mysql' => '
                            SELECT :columns
                                mproty."id" AS "swpost.type.id", mproty."siteid" AS "swpost.type.siteid",
                                mproty."code" AS "swpost.type.code", mproty."domain" AS "swpost.type.domain",
                                mproty."label" AS "swpost.type.label", mproty."status" AS "swpost.type.status",
                                mproty."mtime" AS "swpost.type.mtime", mproty."editor" AS "swpost.type.editor",
                                mproty."ctime" AS "swpost.type.ctime", mproty."pos" AS "swpost.type.position"
                            FROM "sw_post_type" AS mproty
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
                                FROM "sw_post_type" AS mproty
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
                                FROM "sw_post_type" AS mproty
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
                        'oracle' => 'SELECT sw_post_type_seq.CURRVAL FROM DUAL',
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
                        DELETE FROM "sw_post"
                        WHERE :cond AND siteid = ?
                    '
                ),
                'insert' => array(
                    'ansi' => '
                        INSERT INTO "sw_post" ( :names
                            "type", "code", "dataset", "label", "url", "status", "scale", "start", "end",
                            "config", "target", "editor", "mtime", "ctime", "siteid"
                        ) VALUES ( :values
                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                        )
                    '
                ),
                'update' => array(
                    'ansi' => '
                        UPDATE "sw_post"
                        SET :names
                            "type" = ?, "code" = ?, "dataset" = ?, "label" = ?, "url" = ?, "status" = ?, "scale" = ?,
                            "start" = ?, "end" = ?, "config" = ?, "target" = ?, "editor" = ?, "mtime" = ?, "ctime" = ?
                        WHERE "siteid" = ? AND "id" = ?
                    '
                ),
                'rate' => array(
                    'ansi' => '
                        UPDATE "sw_post"
                        SET "rating" = ?, "ratings" = ?
                        WHERE "siteid" = ? AND "id" = ?
                    '
                ),
                'search' => array(
                    'ansi' => '
                        SELECT :columns
                            mpro."id" AS "swpost.id", mpro."siteid" AS "swpost.siteid",
                            mpro."type" AS "swpost.type", mpro."code" AS "swpost.code",
                            mpro."label" AS "swpost.label", mpro."url" AS "swpost.url",
                            mpro."start" AS "swpost.datestart", mpro."end" AS "swpost.dateend",
                            mpro."status" AS "swpost.status", mpro."ctime" AS "swpost.ctime",
                            mpro."mtime" AS "swpost.mtime", mpro."editor" AS "swpost.editor",
                            mpro."target" AS "swpost.target", mpro."dataset" AS "swpost.dataset",
                            mpro."scale" AS "swpost.scale", mpro."config" AS "swpost.config",
                            mpro."rating" AS "swpost.rating", mpro."ratings" AS "swpost.ratings"
                        FROM "sw_post" AS mpro
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
                            mpro."id" AS "swpost.id", mpro."siteid" AS "swpost.siteid",
                            mpro."type" AS "swpost.type", mpro."code" AS "swpost.code",
                            mpro."label" AS "swpost.label", mpro."url" AS "swpost.url",
                            mpro."start" AS "swpost.datestart", mpro."end" AS "swpost.dateend",
                            mpro."status" AS "swpost.status", mpro."ctime" AS "swpost.ctime",
                            mpro."mtime" AS "swpost.mtime", mpro."editor" AS "swpost.editor",
                            mpro."target" AS "swpost.target", mpro."dataset" AS "swpost.dataset",
                            mpro."scale" AS "swpost.scale", mpro."config" AS "swpost.config",
                            mpro."rating" AS "swpost.rating", mpro."ratings" AS "swpost.ratings"
                        FROM "sw_post" AS mpro
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
                            FROM "sw_post" AS mpro
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
                            FROM "sw_post" AS mpro
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
                    'oracle' => 'SELECT sw_post_seq.CURRVAL FROM DUAL',
                    'pgsql' => 'SELECT lastval()',
                    'sqlite' => 'SELECT last_insert_rowid()',
                    'sqlsrv' => 'SELECT @@IDENTITY',
                    'sqlanywhere' => 'SELECT @@IDENTITY',
                ),
            ),
        ),

    ]
];
