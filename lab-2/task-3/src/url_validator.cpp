#include "url_validator.hpp"

#include <QUrl>

UrlValidator::UrlValidator(QObject* parent) : QValidator(parent) {}

QValidator::State UrlValidator::validate(QString& input, int& pos) const {
    const QUrl url{input};

    if (!url.isValid()) {
        return QValidator::Intermediate;
    }

    const QList<QString> valid_schemes = {"http", "https"};

    if (!valid_schemes.contains(url.scheme())) {
        return QValidator::Intermediate;
    }

    QString host = url.host();

    if (host.isEmpty()) {
        return QValidator::Intermediate;
    }

    QStringList parts = host.split(".");

    if (parts.size() < 2 || parts.back().isEmpty()) {
        return QValidator::Intermediate;
    }

    return QValidator::Acceptable;
}
