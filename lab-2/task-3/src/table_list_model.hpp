#pragma once

#include <QAbstractListModel>

template <typename T>
class TableListModel : public QAbstractListModel {
   public:
    TableListModel(QObject* parent = nullptr) : QAbstractListModel(parent) {}

    int rowCount(const QModelIndex&) const override { return values_.count(); }

    int columnCount(const QModelIndex& parent) const override { return 2; }

    QVariant data(const QModelIndex& index, int role) const override {
        const int row = index.row();
        const auto& info = values_.at(row);

        if (role == Qt::DisplayRole) {
            return columnValue(info, index.column());
        } else {
            return QVariant();
        }
    }

    bool isEmpty() const { return values_.isEmpty(); }

    void setColumnNames(QList<QString> column_names) {
        column_names_ = std::move(column_names);
    }

    QVariant headerData(
        int section,  //
        Qt::Orientation orientation,
        int role
    ) const override {
        if (role == Qt::DisplayRole && orientation == Qt::Horizontal &&
            section < column_names_.size()) {
            return column_names_.at(section);
        }
        return QAbstractListModel::headerData(section, orientation, role);
    }

    const QList<T>& values() const { return values_; }

    void setValues(QList<T> values) {
        int idx = values_.count();
        beginInsertRows(QModelIndex(), 1, idx);
        values_ = std::move(values);
        endInsertRows();
    }

    const T& getRow(int row) { return values_[row]; }

    void addRow(T value) {
        int idx = values_.count();
        beginInsertRows(QModelIndex(), idx, idx);
        values_.append(std::move(value));
        endInsertRows();
    }

    void setRow(int row, T value) { values_[row] = value; }

    void removeRow(int row) {
        beginRemoveRows(QModelIndex(), row, row);
        values_.removeAt(row);
        endRemoveRows();
    }

   protected:
    virtual QVariant columnValue(const T& value, int column) const = 0;

   private:
    QList<T> values_;
    QList<QString> column_names_;
};
