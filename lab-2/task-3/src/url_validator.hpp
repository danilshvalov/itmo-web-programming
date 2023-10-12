#pragma once

#include <QValidator>

class UrlValidator : public QValidator {
   public:
    UrlValidator(QObject* parent = nullptr);

    State validate(QString& input, int& pos) const override;
};
