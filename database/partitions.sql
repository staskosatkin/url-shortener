
CREATE TABLE application.urls_1 (like application.urls including all);
ALTER TABLE application.urls_1 inherit application.urls;

CREATE TABLE application.urls_2 (like application.urls including all);
ALTER TABLE application.urls_2 inherit application.urls;

CREATE TABLE application.urls_3 (like application.urls including all);
ALTER TABLE application.urls_3 inherit application.urls;

CREATE TABLE application.urls_4 (like application.urls including all);
ALTER TABLE application.urls_4 inherit application.urls;

CREATE TABLE application.urls_5 (like application.urls including all);
ALTER TABLE application.urls_5 inherit application.urls;

CREATE TABLE application.urls_6 (like application.urls including all);
ALTER TABLE application.urls_6 inherit application.urls;

CREATE TABLE application.urls_7 (like application.urls including all);
ALTER TABLE application.urls_7 inherit application.urls;

CREATE TABLE application.urls_8 (like application.urls including all);
ALTER TABLE application.urls_8 inherit application.urls;

CREATE TABLE application.urls_9 (like application.urls including all);
ALTER TABLE application.urls_9 inherit application.urls;

CREATE TABLE application.urls_10 (like application.urls including all);
ALTER TABLE application.urls_10 inherit application.urls;

CREATE FUNCTION select_urls_partition(h varchar) RETURNS integer AS $$
BEGIN
    RETURN abs( hashtext(h) ) % 10;
END;
$$ LANGUAGE plpgsql IMMUTABLE;

show constraint_exclusion;
explain analyze select * from application.urls where hash = :hash and select_urls_partition(:hash) = select_urls_partition(hash);
explain analyze select * from application.urls where hash = :hash;

ALTER TABLE application.urls_1 add constraint partition_check check ( select_urls_partition(hash) = 0 );
ALTER TABLE application.urls_2 add constraint partition_check check ( select_urls_partition(hash) = 1 );
ALTER TABLE application.urls_3 add constraint partition_check check ( select_urls_partition(hash) = 2 );
ALTER TABLE application.urls_4 add constraint partition_check check ( select_urls_partition(hash) = 3 );
ALTER TABLE application.urls_5 add constraint partition_check check ( select_urls_partition(hash) = 4 );
ALTER TABLE application.urls_6 add constraint partition_check check ( select_urls_partition(hash) = 5 );
ALTER TABLE application.urls_7 add constraint partition_check check ( select_urls_partition(hash) = 6 );
ALTER TABLE application.urls_8 add constraint partition_check check ( select_urls_partition(hash) = 7 );
ALTER TABLE application.urls_9 add constraint partition_check check ( select_urls_partition(hash) = 8 );
ALTER TABLE application.urls_10 add constraint partition_check check ( select_urls_partition(hash) = 9 );

ALTER TABLE application.urls_1 drop constraint partition_check;
ALTER TABLE application.urls_2 drop constraint partition_check;
ALTER TABLE application.urls_3 drop constraint partition_check;
ALTER TABLE application.urls_4 drop constraint partition_check;
ALTER TABLE application.urls_5 drop constraint partition_check;
ALTER TABLE application.urls_6 drop constraint partition_check;
ALTER TABLE application.urls_7 drop constraint partition_check;
ALTER TABLE application.urls_8 drop constraint partition_check;
ALTER TABLE application.urls_9 drop constraint partition_check;
ALTER TABLE application.urls_10 drop constraint partition_check;

DROP TABLE application.urls;
DROP TABLE application.urls_1;
DROP TABLE application.urls_2;
DROP TABLE application.urls_3;
DROP TABLE application.urls_4;
DROP TABLE application.urls_5;
DROP TABLE application.urls_6;
DROP TABLE application.urls_7;
DROP TABLE application.urls_8;
DROP TABLE application.urls_9;
DROP TABLE application.urls_10;

TRUNCATE TABLE application.urls;


CREATE FUNCTION application.insert_to_partition() RETURNS TRIGGER AS $$
DECLARE
    v_partition_name text;
BEGIN
    v_partition_name := format ('application.urls_%s', 1 + select_urls_partition(NEW.hash));
    EXECUTE 'INSERT INTO ' || v_partition_name || ' VALUES ( ($1).* )' USING NEW;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER partition_urls BEFORE INSERT ON application.urls FOR EACH ROW EXECUTE PROCEDURE application.insert_to_partition();

CREATE FUNCTION application.delete_from_master() RETURNS TRIGGER AS $$
BEGIN
    DELETE FROM ONLY application.urls WHERE hash = NEW.hash;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER partition_urls_cleanup_master AFTER INSERT ON application.urls FOR EACH ROW EXECUTE PROCEDURE application.delete_from_master();

SELECT * FROM ONLY application.urls;
SELECT * FROM application.urls;

EXPLAIN ANALYSE SELECT COUNT(*) FROM application.urls;
SELECT COUNT(*) FROM application.urls;
SELECT 'urls_1', COUNT(*) FROM application.urls_1 UNION ALL
SELECT 'urls_2', COUNT(*) FROM application.urls_2 UNION ALL
SELECT 'urls_3', COUNT(*) FROM application.urls_3 UNION ALL
SELECT 'urls_4', COUNT(*) FROM application.urls_4 UNION ALL
SELECT 'urls_5', COUNT(*) FROM application.urls_5 UNION ALL
SELECT 'urls_6', COUNT(*) FROM application.urls_6 UNION ALL
SELECT 'urls_7', COUNT(*) FROM application.urls_7 UNION ALL
SELECT 'urls_8', COUNT(*) FROM application.urls_8 UNION ALL
SELECT 'urls_9', COUNT(*) FROM application.urls_9 UNION ALL
SELECT 'urls_10', COUNT(*) FROM application.urls_10;

DROP FUNCTION select_urls_partition;

DROP TRIGGER partition_urls ON application.urls;
DROP FUNCTION application.insert_to_partition;

DROP TRIGGER partition_urls_cleanup_master ON application.urls;
DROP FUNCTION application.delete_from_master;
